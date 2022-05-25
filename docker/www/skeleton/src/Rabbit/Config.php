<?php

namespace EfTech\ContactList\Rabbit;

use RuntimeException;

/**
 * Конфиг подключения реббит
 */
class Config
{
    /**
     * Путь до файла с конфигами
     */
    public const FILE_CONFIG = __DIR__ . '/../../config/config_rabbit/config_rabbit.php';

    /**
     *  Обязательные ключи которые должны быть для подключения к rabbitmq
     */
    private const REQUIRED_CONFIG_KEY = [
        'host',
        'user',
        'password',
        'port',
        'vhost'
    ];

    /** Пользователь rabbit
     * @var string
     */
    private string $user;

    /** Пароль пользователя rabbit
     * @var string
     */
    private string $password;

    /** Хост для подключения к rabbit
     * @var string
     */
    private string $host;

    /**
     * Порт, который слушает сервер rabbit
     * @var string
     */
    private string $port;

    /**
     * Виртуальный хост rabbit
     * @var string
     */
    private string $vhost;

    /**
     * @param array $config
     */
    private function __construct(array $config)
    {
        $this->validate($config);
        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->vhost = $config['vhost'];
    }

    /**
     * Валидация данных для подключения
     *
     * @param array $config
     * @return void
     */
    private function validate(array $config): void
    {
        $errors = [];
        if ('' === trim($config['vhost'])) {
            $errors[] = 'Необходимо указать корректный виртуальный хост rabbit';
        }
        if ('' === trim($config['user'])) {
            $errors[] = 'Необходимо указать корректное имя пользователя rabbit';
        }
        if ('' === trim($config['port'])) {
            $errors[] = 'Необходимо указать корректный порт rabbit';
        }
        if ('' === trim($config['host'])) {
            $errors[] = 'Необходимо указать корректный хост rabbit';
        }

        if (count($errors) > 0) {
            $errMsg = implode("\n", $errors);
            throw new RuntimeException($errMsg);
        }
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getVhost(): string
    {
        return $this->vhost;
    }

    /**
     * Фабрика по созданию конфига
     *
     * @return static
     */
    public static function factory(): self
    {
        $config = require_once self::FILE_CONFIG;
        $missingFields = [];
        foreach (self::REQUIRED_CONFIG_KEY as $fieldName) {
            if (false === array_key_exists($fieldName, $config)) {
                $missingFields[] = $fieldName;
            }
        }

        if (count($missingFields) > 0) {
            $errMsg = 'Для соединения с rabbit необходимо указать:' . implode(',', $missingFields);
            throw new RuntimeException($errMsg);
        }
        return new self($config);
    }
}