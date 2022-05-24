<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Service\ListeningToQueueService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetDataQueueController extends AbstractController
{
    /**
     * @var ListeningToQueueService
     */
    private ListeningToQueueService $listeningToQueueService;
    /**
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

    public function __invoke(Request $request): Response
    {
        $this->logger->info('Controller listening');
        $result = $this->listeningToQueueService->listening('queue10m');
        $html = "<h1>Пришло: <h1/>";
//        foreach ($result as $value) {
//            $html.=$value . "\n";
//        }
        $html.=$result;
        return new Response($html);
    }
}