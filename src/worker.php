<?php
//recieve.php in lesson 2
require_once dirname(__DIR__, 1 ) . '/vendor/autoload.php';
require_once __DIR__.'/config/connection.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(
    MQ_SERVER_CONNECTION['host'],
    MQ_SERVER_CONNECTION['port'],
    MQ_SERVER_CONNECTION['user'],
    MQ_SERVER_CONNECTION['password']
);

$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);
echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null); //подписчик не получит новое сообщение, до тех пор пока не обработает и не подтвердит предыдущее
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();