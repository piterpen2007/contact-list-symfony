<?php

namespace EfTech\ContactList\Service;

use EfTech\ContactList\Rabbit\RabbitConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Log\LoggerInterface;

class ListeningToQueueService
{
    /**
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


    public function listening(string $queue):string
    {
        $this->logger->info('Listening queue');
        $connect = $this->rabbitConnection->getConnection();
        $channel = $connect->channel();
        $channel->queue_declare($queue,false,false,false,false);

        $result = $channel->basic_get($queue, true);
        $msg = '';
        if (!is_null($result)) {
            $msg = $result->getBody();
        }
        $channel->close();
        $connect->close();
        return $msg;

    }

}