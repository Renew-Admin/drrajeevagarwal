<?php
declare(strict_types=1);

require __DIR__ . '/webhook-proxy.php';

webhook_forward(
    'WORKSHOP_WEBHOOK',
    'Webhook rejected the workshop payload.',
    'Workshop webhook delivery failed.'
);
