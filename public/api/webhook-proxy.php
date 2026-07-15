<?php
declare(strict_types=1);

const WEBHOOK_MAX_BODY_BYTES = 1048576;

function webhook_headers(): void
{
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
}

function webhook_json_response(int $statusCode, array $body): void
{
    http_response_code($statusCode);
    webhook_headers();
    echo json_encode($body, JSON_UNESCAPED_SLASHES);
    exit;
}

function webhook_config(): array
{
    static $config = null;

    if ($config !== null) {
        return $config;
    }

    $config = [];
    $configPath = __DIR__ . '/.env.php';

    if (is_file($configPath)) {
        $loaded = require $configPath;
        if (is_array($loaded)) {
            $config = $loaded;
        }
    }

    return $config;
}

function webhook_config_value(string $name): string
{
    $serverValue = getenv($name);

    if (is_string($serverValue) && trim($serverValue) !== '') {
        return trim($serverValue);
    }

    $config = webhook_config();
    $fileValue = $config[$name] ?? '';

    return is_string($fileValue) ? trim($fileValue) : '';
}

function webhook_request_meta(): array
{
    return [
        'forwarded_for' => $_SERVER['HTTP_CF_CONNECTING_IP']
            ?? $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? null,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
        'referer' => $_SERVER['HTTP_REFERER'] ?? null,
    ];
}

function webhook_read_payload(): array
{
    $rawBody = file_get_contents('php://input');

    if ($rawBody === false) {
        webhook_json_response(400, ['error' => 'Could not read request body.']);
    }

    if (strlen($rawBody) > WEBHOOK_MAX_BODY_BYTES) {
        webhook_json_response(413, ['error' => 'Request body too large.']);
    }

    $payload = json_decode($rawBody === '' ? '{}' : $rawBody, true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($payload)) {
        webhook_json_response(400, ['error' => 'Invalid JSON payload.']);
    }

    return $payload;
}

function webhook_parse_status_code(array $headers): int
{
    $statusCode = 0;

    foreach ($headers as $header) {
        if (preg_match('/^HTTP\/\S+\s+(\d{3})/', $header, $matches)) {
            $statusCode = (int) $matches[1];
        }
    }

    return $statusCode;
}

function webhook_post_json_with_stream(string $url, string $body): array
{
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $body,
            'ignore_errors' => true,
            'timeout' => 15,
        ],
    ]);

    $responseBody = @file_get_contents($url, false, $context);
    $headers = isset($http_response_header) && is_array($http_response_header) ? $http_response_header : [];

    if ($responseBody === false && !$headers) {
        throw new RuntimeException('Webhook request failed.');
    }

    return [
        'status' => webhook_parse_status_code($headers),
        'body' => $responseBody === false ? '' : $responseBody,
    ];
}

function webhook_post_json(string $url, string $body): array
{
    if (!function_exists('curl_init')) {
        return webhook_post_json_with_stream($url, $body);
    }

    $handle = curl_init($url);

    if ($handle === false) {
        throw new RuntimeException('Could not initialize webhook request.');
    }

    curl_setopt_array($handle, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 20,
    ]);

    $responseBody = curl_exec($handle);
    $statusCode = (int) curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if ($responseBody === false) {
        $message = curl_error($handle) ?: 'Webhook request failed.';
        curl_close($handle);
        throw new RuntimeException($message);
    }

    curl_close($handle);

    return [
        'status' => $statusCode,
        'body' => is_string($responseBody) ? $responseBody : '',
    ];
}

function webhook_forward(string $envName, string $rejectedMessage, string $failedMessage): void
{
    webhook_headers();

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        webhook_json_response(405, ['error' => 'Method not allowed.']);
    }

    $webhookUrl = webhook_config_value($envName);

    if ($webhookUrl === '') {
        webhook_json_response(500, ['error' => $envName . ' is not configured.']);
    }

    $payload = webhook_read_payload();
    $payload['request'] = webhook_request_meta();
    $encodedPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);

    if (!is_string($encodedPayload)) {
        webhook_json_response(400, ['error' => 'Could not encode webhook payload.']);
    }

    try {
        $response = webhook_post_json($webhookUrl, $encodedPayload);
    } catch (Throwable $error) {
        webhook_json_response(502, [
            'error' => $failedMessage,
            'message' => $error->getMessage(),
        ]);
    }

    $statusCode = (int) ($response['status'] ?? 0);

    if ($statusCode < 200 || $statusCode >= 300) {
        webhook_json_response(502, [
            'error' => $rejectedMessage,
            'status' => $statusCode,
            'body' => substr((string) ($response['body'] ?? ''), 0, 500),
        ]);
    }

    webhook_json_response(200, ['ok' => true]);
}
