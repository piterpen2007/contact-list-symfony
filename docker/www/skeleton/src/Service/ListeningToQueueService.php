<?php

namespace EfTech\ContactList\Service;

use EfTech\ContactList\Rabbit\RabbitConnection;
use Exception;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

/**
 * Класс для работы с реббитом
 *
 */
class ListeningToQueueService
{

    /**
     * Имя очереди
     */
    public const QUEUE_NAME = 'queue10m';
    /**
     * Логгер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Подключение к rabbitmq
     *
     * @var RabbitConnection
     */
    private RabbitConnection $rabbitConnection;

    /**
     * Объект для работы с rabbit сообщениями
     *
     * @var AMQPMessage
     */
    private AMQPMessage $AMQPMessage;

    /**
     * @param LoggerInterface $logger
     * @param RabbitConnection $rabbitConnection
     * @param AMQPMessage $AMQPMessage - работает через di только
     * если прописать заранее в сервисах /skeleton/config/services.yaml
     */
    public function __construct(LoggerInterface $logger, RabbitConnection $rabbitConnection, AMQPMessage $AMQPMessage)
    {
        $this->logger = $logger;
        $this->rabbitConnection = $rabbitConnection;
        $this->AMQPMessage = $AMQPMessage;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @return RabbitConnection
     */
    public function getRabbitConnection(): RabbitConnection
    {
        return $this->rabbitConnection;
    }

    /**
     * @return AMQPMessage
     */
    public function getAMQPMessage(): AMQPMessage
    {
        return $this->AMQPMessage;
    }

    /**
     * Отправляет в очередь сообщение
     *
     * @param string $message - сообщение
     * @param string $queue - имя очереди
     * @return void
     * @throws Exception
     */
    public function send(string $message, string $queue): void
    {
        $this->logger->info('Сервис отправки сообщения в реббит');
        $connect = $this->rabbitConnection->getConnection();
        $channel = $connect->channel();
        $channel->queue_declare($queue, false, false, false, false);
        $msg = $this->AMQPMessage->setBody($message);
        $channel->basic_publish($msg, '', $queue);
        $channel->close();
        $connect->close();
    }

    /**
     * Слушает очередь и возвращает сообщение
     *
     * @param string $queue - имя очереди
     * @return string - сообщение из очереди
     * @throws Exception
     */
    public function listening(string $queue): string
    {
        $this->logger->info('Listening queue');
        $connect = $this->rabbitConnection->getConnection();
        $channel = $connect->channel();
        $channel->queue_declare($queue, false, false, false, false);

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