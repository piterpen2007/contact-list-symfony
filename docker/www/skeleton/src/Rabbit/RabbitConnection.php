<?php
namespace EfTech\ContactList\Rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Класс подключения к rabbitmq
 */
class RabbitConnection
{
    /**
     * @var AMQPStreamConnection|null
     */
    private ?AMQPStreamConnection $connection = null;

    /**
     * Возвращает объект подключения к rabbitmq
     *
     * @return AMQPStreamConnection
     */
    public function getConnection(): AMQPStreamConnection
    {
        if ($this->connection === null) {
            $this->connection = $this->createConnection();
        }
        return $this->connection;
    }

    /**
     * Создание подключения из конфига
     *
     * @return AMQPStreamConnection
     */
    public function createConnection(): AMQPStreamConnection
    {
        $config = require_once __DIR__ . '/../../config/config_rabbit/config_rabbit.php';
        return new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password'],
            $config['vhost']
        );
    }
}