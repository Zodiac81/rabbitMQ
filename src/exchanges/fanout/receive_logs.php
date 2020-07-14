<?php

require_once dirname(__DIR__, 3 ) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/config/connection.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(
    MQ_SERVER_CONNECTION['host'],
    MQ_SERVER_CONNECTION['port'],
    MQ_SERVER_CONNECTION['user'],
    MQ_SERVER_CONNECTION['password']
);

$channel = $connection->channel();

$channel->exchange_declare('logs', 'fanout', false, false, false);

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

$binding_key = 'black';
$channel->queue_bind($queue_name, 'logs', $binding_key);
echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

$callback = function($msg){
    echo ' [x] ', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

