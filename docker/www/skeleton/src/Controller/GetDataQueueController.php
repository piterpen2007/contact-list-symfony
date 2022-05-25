<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Service\ListeningToQueueService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetDataQueueController extends AbstractController
{
    /**
     * Сервис для работы с реббитом
     *
     * @var ListeningToQueueService
     */
    private ListeningToQueueService $listeningToQueueService;
    /**
     * Логгер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param ListeningToQueueService $listeningToQueueService
     * @param LoggerInterface $logger
     */
    public function __construct(ListeningToQueueService $listeningToQueueService, LoggerInterface $logger)
    {
        $this->listeningToQueueService = $listeningToQueueService;
        $this->logger = $logger;
    }

    /**
     * @param Request $request - http запрос
     * @return Response - http ответ
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $this->logger->info('Controller listening');
        $result = $this->listeningToQueueService->listening('queue10m');
        $html = "<h1>Пришло: <h1/>";
        $html .= $result;
        return new Response($html);
    }
}