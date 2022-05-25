<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Service\ListeningToQueueService;
use Exception;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListeningToQueueController extends AbstractController
{
    /**
     * Логгер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Сервис для работы с реббитом
     *
     * @var ListeningToQueueService
     */
    private ListeningToQueueService $listeningToQueueService;

    /**
     * @param LoggerInterface $logger
     * @param ListeningToQueueService $listeningToQueueService
     */
    public function __construct(LoggerInterface $logger, ListeningToQueueService $listeningToQueueService)
    {
        $this->logger = $logger;
        $this->listeningToQueueService = $listeningToQueueService;
    }

    /**
     * @param Request $request - http запрос
     * @return Response - http ответ
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $this->logger->info("Ветка listeningToQueueController");

        $params = array_merge($request->query->all(), $request->attributes->all());

        if (!array_key_exists('message', $params)) {
            throw new RuntimeException('Не передали параметр message');
        }

        $this->listeningToQueueService->send($params['message'], ListeningToQueueService::QUEUE_NAME);
        $html = "<h1>Отправлено: " . $params['message'] . "<h1/>";

        return new Response($html);
    }
}