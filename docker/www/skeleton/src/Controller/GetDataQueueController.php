<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Service\WorkWithRabbitService;
use Exception;
use Psr\Log\LoggerInterface;
use RuntimeException;
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

        $params = array_merge($request->query->all(), $request->attributes->all());

        if (!array_key_exists('queue', $params)) {
            throw new RuntimeException('Не передали параметр queue');
        }

        $result = $this->getWorkWithRabbitService()->getOneMessageFromAnUnknownQueue($params['queue']);
        $html = "<h1>Пришло: <h1/>";
        foreach ($result as $value) {
            $html .=' ' . $value;
        }

        return new Response($html);
    }
}