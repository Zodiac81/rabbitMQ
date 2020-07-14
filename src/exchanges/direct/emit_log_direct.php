<?php

require_once dirname(__DIR__, 3 ) . '/vendor/autoload.php';
require_once dirname(__DIR__,2 ) .'/config/connection.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(
    MQ_SERVER_CONNECTION['host'],
    MQ_SERVER_CONNECTION['port'],
    MQ_SERVER_CONNECTION['user'],
    MQ_SERVER_CONNECTION['password']
);

$channel = $connection->channel();

$channel->exchange_declare('direct_logs', 'direct', false, false, false);

$severity = $argv[1];

if(empty($severity)) $severity = "info";

$data = implode(' ', array_slice($argv, 2));
if(empty($data)) $data = "info: Hello World!";
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'direct_logs', $severity);

echo " [x] Sent ",$severity,':',$data," \n";

$channel->close();
$connection->close();

