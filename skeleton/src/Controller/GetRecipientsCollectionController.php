<?php

namespace EfTech\ContactList\Controller;

use Psr\Log\LoggerInterface;
use EfTech\ContactList\Service\SearchRecipientsService\RecipientDto;
use EfTech\ContactList\Service\SearchRecipientsService\SearchRecipientsCriteria;
use EfTech\ContactList\Service\SearchRecipientsService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetRecipientsCollectionController extends AbstractController
{
    /**
     * Сервис валидации
     *
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     *
     *
     * @var SearchRecipientsService
     */
    private SearchRecipientsService $searchRecipientsService;
    /** Логгер
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     * @param SearchRecipientsService $searchRecipientsService
     * @param ValidatorInterface $validator
     */
    public function __construct(
        LoggerInterface $logger,
        SearchRecipientsService $searchRecipientsService,
        \Symfony\Component\Validator\Validator\ValidatorInterface $validator
    ) {
        $this->logger = $logger;
        $this->searchRecipientsService = $searchRecipientsService;
        $this->validator = $validator;
    }

    /**  Валдирует параматры запроса
     * @param Request $request
     * @return string|null
     * @throws Exception
     */
    private function validateQueryParams(Request $request): ?string
    {
        $constraint = [
            new Assert\Collection(
                [
                    'allowExtraFields' => true,
                    'allowMissingFields' => true,
                    'fields' => [
                        'id_recipient' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect id_recipient']),
                            ]
                        ),
                        'full_name' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect full_name']),
                            ]
                        ),
                        'birthday' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect birthday']),
                            ]
                        ),
                        'profession' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect profession']),
                            ]
                        )
                    ]
                ]
            ),
        ];

        $params = array_merge($request->query->all(), $request->attributes->all());
        $errors = $this->validator->validate($params, $constraint);
        $errStrCollection =  array_map(static function($v) {
            return $v->getMessage();
        },$errors->getIterator()->getArrayCopy());

        return count($errStrCollection) > 0 ? implode(',', $errStrCollection) : null;
    }


    /**
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $this->logger->info("Ветка recipient");

        $resultOfParamValidation = $this->validateQueryParams($request);

        if (null === $resultOfParamValidation) {
            $params = array_merge($request->query->all(), $request->attributes->all());
            $foundRecipients = $this->searchRecipientsService->search(
                (new SearchRecipientsCriteria())
                    ->setIdRecipient($params['id_recipient'] ?? null)
                    ->setFullName($params['full_name'] ?? null)
                    ->setBirthday($params['birthday'] ?? null)
                    ->setProfession($params['profession'] ?? null)
            );

            $httpCode = $this->buildHttpCode($foundRecipients);
            $result = $this->buildResult($foundRecipients);
        } else {
            $httpCode = 500;

            $result = [
                'status' => 'fail',
                'message' => $resultOfParamValidation
            ];
        }
        return $this->json($result, $httpCode);
    }
    /** Определяет http code
     * @param array $foundRecipients
     * @return int
     */
    protected function buildHttpCode(array $foundRecipients): int
    {
        return 200;
    }

    /** Подготавливает данные для ответа
     * @param array $foundRecipients
     * @return array
     */
    protected function buildResult(array $foundRecipients): array
    {
        $result = [];
        foreach ($foundRecipients as $foundRecipient) {
            $result[] = $this->serializeRecipient($foundRecipient);
        }
        return $result;
    }

    /**
     * @param RecipientDto $recipientDto
     * @return array
     */
    final protected function serializeRecipient(RecipientDto $recipientDto): array
    {
        $jsonData = [
            'id_recipient' => $recipientDto->getIdRecipient(),
            'full_name' => $recipientDto->getFullName(),
            'birthday' => $recipientDto->getBirthday()->format('d.m.Y'),
            'profession' => $recipientDto->getProfession()
        ];
        $jsonData['emails'] = array_values(
            array_map(static function ($email) {
                return [
                    'email' => $email->getEmail(),
                    'type_email' => $email->getTypeEmail(),
                ];
            }, $recipientDto->getEmails())
        );
        return $jsonData;
    }
}
