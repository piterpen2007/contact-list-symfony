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
class WorkWithRabbitService
{

    public const FANOUT_TYPE = 'fanout';
    /**
     * Имя обмена
     */
    public const  EXCHANGE_NAME = 'logs';
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
        $this->getLogger()->info('Сервис отправки сообщения в реббит');
        $connect = $this->getRabbitConnection()->getConnection();
        $channel = $connect->channel();
        $channel->queue_declare($queue, false, false, false, false);
        $msg = $this->getAMQPMessage()->setBody($message);
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
    public function getOneMessage(string $queue): string
    {
        $this->getLogger()->info('Listening queue');
        $connect = $this->getRabbitConnection()->getConnection();
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

    /**
     * Отправляет сообщение во все очереди
     *
     * @param string $message
     * @return void
     * @throws Exception
     */
    public function sendingToAllQueues(string $message): void
    {
        $this->getLogger()->info('Отправка сообщения всем очередям');
        $connect = $this->getRabbitConnection()->getConnection();
        $channel = $connect->channel();

        $channel->exchange_declare(
            WorkWithRabbitService::EXCHANGE_NAME,
            WorkWithRabbitService::FANOUT_TYPE,
            false,
            false,
            false
        );

        $msg = $this->getAMQPMessage()->setBody($message);

        $channel->basic_publish($msg, WorkWithRabbitService::EXCHANGE_NAME);

        $channel->close();
        $connect->close();
    }

    /**
     * Слушает конкретно свою очередь
     *
     * @param string $queue - очередь для прослушки
     * @return array
     * @throws Exception
     */
    public function getOneMessageFromAnUnknownQueue(string $queue): array
    {
        $this->getLogger()->info('Слушает свою очередь неизвестную');
        $connect = $this->getRabbitConnection()->getConnection();
        $channel = $connect->channel();

        $channel->exchange_declare(
            WorkWithRabbitService::EXCHANGE_NAME,
            WorkWithRabbitService::FANOUT_TYPE,
            false,
            false,
            false
        );

        $channel->queue_declare(
            $queue,
            false,
            false,
            true,
            false
        );

        $messages = [];
        $callback = function($msg) use (&$messages) {
            $messages[] = $msg->body;
        };

        $channel->queue_bind($queue, WorkWithRabbitService::EXCHANGE_NAME);

        $channel->basic_consume($queue, '', false, true, false, false, $callback);

        $timeout = 10;
        while (count($channel->callbacks)) {
            try{
                $channel->wait(null, false , $timeout);
            }catch(\PhpAmqpLib\Exception\AMQPTimeoutException $e){
                $channel->close();
                $connect->close();
                return $messages;
            }
        }
//        $result = $channel->basic_get($queue, true);
//        $msg = '';
//        if (!is_null($result)) {
//            $msg = $result->getBody();
//        }
        $channel->close();
        $connect->close();
        return $messages;
    }
}