<?php
//in lesson 1 this file named send
require_once dirname(__DIR__, 1 ) . '/vendor/autoload.php';
require_once __DIR__.'/config/connection.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(
    MQ_SERVER_CONNECTION['host'],
    MQ_SERVER_CONNECTION['port'],
    MQ_SERVER_CONNECTION['user'],
    MQ_SERVER_CONNECTION['password']
);

$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}
$msg = new AMQPMessage(
    $data,
    ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT] //при рестарте сервера реббита сообщения не потряются
);

$channel->basic_publish($msg, '', 'task_queue');

echo ' [x] Sent ', $data, "\n";