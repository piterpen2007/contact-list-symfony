<?php

require_once  __DIR__ . '/../../vendor/autoload.php' ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connect = new AMQPStreamConnection('0.0.0.0','5672','user', 'password','my_vhost');

$channel = $connect->channel();

$channel->queue_declare('queue10');

$msg = new AMQPMessage('Сообщение из очереди1234');

$channel->basic_publish($msg, '');

echo 'Отправлено сообщение в очередь'. "\n";

$channel->close();

$connect->close();