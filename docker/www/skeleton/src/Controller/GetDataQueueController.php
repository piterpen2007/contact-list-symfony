<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Service\WorkWithRabbitService;
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
     * @var WorkWithRabbitService
     */
    private WorkWithRabbitService $workWithRabbitService;

    /**
     * @return WorkWithRabbitService
     */
    public function getWorkWithRabbitService(): WorkWithRabbitService
    {
        return $this->workWithRabbitService;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Логгер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param WorkWithRabbitService $workWithRabbitService
     * @param LoggerInterface $logger
     */
    public function __construct(WorkWithRabbitService $workWithRabbitService, LoggerInterface $logger)
    {
        $this->workWithRabbitService = $workWithRabbitService;
        $this->logger = $logger;
    }

    /**
     * @param Request $request - http запрос
     * @return Response - http ответ
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $this->getLogger()->info('Controller listening');
        $result = $this->getWorkWithRabbitService()->getOneMessage(WorkWithRabbitService::QUEUE_NAME);
        $html = "<h1>Пришло: <h1/>";
        $html .= $result;
        return new Response($html);
    }
}