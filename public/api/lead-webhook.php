<?php
declare(strict_types=1);

require __DIR__ . '/webhook-proxy.php';

webhook_forward(
    'WEBHOOK_URL',
    'Webhook rejected the lead payload.',
    'Webhook delivery failed.'
);
