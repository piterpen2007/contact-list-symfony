<?php
require_once  __DIR__ . '/../../vendor/autoload.php' ;

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connect = new AMQPStreamConnection('0.0.0.0','5672','user', 'password','my_vhost');

$channel = $connect->channel();

$channel->queue_declare('queue10',false,false,false,true);

echo 'Ожидание сообщений:';

$callback = function ($msg) {
    echo 'Пришло:' . $msg->body . "\n";
};

$channel->basic_consume('queue10','',false,true,false,false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connect->close();