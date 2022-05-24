<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Service\SendDataToRabbit;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListeningToQueueController extends AbstractController
{
    /** Логгер
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    private SendDataToRabbit $sendDataToRabbit;

    /**
     * @param LoggerInterface $logger
     * @param SendDataToRabbit $sendDataToRabbit
     */
    public function __construct(LoggerInterface $logger, SendDataToRabbit $sendDataToRabbit)
    {
        $this->logger = $logger;
        $this->sendDataToRabbit = $sendDataToRabbit;
    }

    public function __invoke(Request $request): Response
    {
        $this->logger->info("Ветка listeningToQueueController");

        $params = array_merge($request->query->all(), $request->attributes->all());

        if (!array_key_exists('message',$params)) {
            throw new RuntimeException('Не передали параметр message');
        }

        $this->sendDataToRabbit->send($params['message']);
        $html = "<h1>Отправлено: " . $params['message'] . "<h1/>";

        return new Response($html);
    }
}