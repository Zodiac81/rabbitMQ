<?php

require_once '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(
    'localhost',
    5672,
    'guest',
    'guest'
);

$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$message = 'Some Message';
$msg = new AMQPMessage($message);
$channel->basic_publish($msg, '', 'hello');

echo "[x] Sent " . $message . "\n";

$channel->close();
$connection->close();