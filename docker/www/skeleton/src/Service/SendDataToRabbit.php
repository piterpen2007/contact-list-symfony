<?php

namespace EfTech\ContactList\Service;

use EfTech\ContactList\Rabbit\RabbitConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class SendDataToRabbit
{
    /**
     *
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    private RabbitConnection $rabbitConnection;


    /**
     * @param LoggerInterface $logger
     * @param RabbitConnection $rabbitConnection
     */
    public function __construct(LoggerInterface $logger, RabbitConnection $rabbitConnection)
    {
        $this->logger = $logger;
        $this->rabbitConnection = $rabbitConnection;
    }

    public function send(string $message): void
    {
        $this->logger->info('Сервис отправки сообщения в реббит');
        $connect = $this->rabbitConnection->getConnection();
        $channel = $connect->channel();
        $channel->queue_declare('queue10m',false,false,false,false);
        $msg = new AMQPMessage($message);

        $channel->basic_publish($msg, '','queue10m');

        $channel->close();
        $connect->close();
    }

}