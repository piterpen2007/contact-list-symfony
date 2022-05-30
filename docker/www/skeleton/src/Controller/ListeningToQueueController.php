<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Service\WorkWithRabbitService;
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
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

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
     * @param LoggerInterface $logger
     * @param WorkWithRabbitService $workWithRabbitService
     */
    public function __construct(LoggerInterface $logger, WorkWithRabbitService $workWithRabbitService)
    {
        $this->logger = $logger;
        $this->workWithRabbitService = $workWithRabbitService;
    }

    /**
     * @param Request $request - http запрос
     * @return Response - http ответ
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $this->getLogger()->info("Ветка listeningToQueueController");

        $params = array_merge($request->query->all(), $request->attributes->all());

        if (!array_key_exists('message', $params)) {
            throw new RuntimeException('Не передали параметр message');
        }

        $this->getWorkWithRabbitService()->sendingToAllQueues($params['message']);
        $html = "<h1>Отправлено: " . $params['message'] . "<h1/>";

        return new Response($html);
    }
}