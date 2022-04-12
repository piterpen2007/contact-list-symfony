<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Service\SearchKinsfolkService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use EfTech\ContactList\Service\SearchKinsfolkService\KinsfolkDto;
use EfTech\ContactList\ValueObject\Email;
use Psr\Log\LoggerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetKinsfolkCollectionController extends AbstractController
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
     * @var SearchKinsfolkService
     */
    private SearchKinsfolkService $searchKinsfolkService;
    /** Логгер
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     * @param SearchKinsfolkService $searchKinsfolkService
     * @param ValidatorInterface $validator
     */
    public function __construct(
        LoggerInterface $logger,
        SearchKinsfolkService $searchKinsfolkService,
        \Symfony\Component\Validator\Validator\ValidatorInterface $validator
    ) {
        $this->logger = $logger;
        $this->searchKinsfolkService = $searchKinsfolkService;
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
                        ),
                        'status' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect status']),
                            ]
                        ),
                        'ringtone' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect ringtone']),
                            ]
                        ),
                        'hotkey' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect hotkey']),
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
        $this->logger->info("Ветка kinsfolk");

        $resultOfParamValidation = $this->validateQueryParams($request);

        if (null === $resultOfParamValidation) {
            $params = array_merge($request->query->all(), $request->attributes->all());
            $foundKinsfolk = $this->searchKinsfolkService->search(
                (new SearchKinsfolkService\SearchKinsfolkCriteria())
                    ->setIdRecipient($params['id_recipient'] ?? null)
                    ->setFullName($params['full_name'] ?? null)
                    ->setBirthday($params['birthday'] ?? null)
                    ->setProfession($params['profession'] ?? null)
                    ->setStatus($params['status'] ?? null)
                    ->setHotkey($params['hotkey'] ?? null)
                    ->setRingtone($params['ringtone'] ?? null)
            );

            $httpCode = $this->buildHttpCode($foundKinsfolk);
            $result = $this->buildResult($foundKinsfolk);
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
     * @param array $foundKinsfolk
     * @return int
     */
    protected function buildHttpCode(array $foundKinsfolk): int
    {
        return 200;
    }

    /** Подготавливает данные для ответа
     * @param array $foundKinsfolk
     * @return array
     */
    protected function buildResult(array $foundKinsfolk): array
    {
        $result = [];
        foreach ($foundKinsfolk as $foundKinsfolkItem) {
            $result[] = $this->serializeRecipient($foundKinsfolkItem);
        }
        return $result;
    }

    /**
     * @param KinsfolkDto $kinsfolkDto
     * @return array
     */
    final protected function serializeRecipient(KinsfolkDto $kinsfolkDto): array
    {
        $jsonData = [
            'id_recipient' => $kinsfolkDto->getIdRecipient(),
            'full_name' => $kinsfolkDto->getFullName(),
            'birthday' => $kinsfolkDto->getBirthday()->format('Y-m-d'),
            'profession' => $kinsfolkDto->getProfession(),
            'status' => $kinsfolkDto->getStatus(),
            'ringtone' => $kinsfolkDto->getRingtone(),
            'hotkey' => $kinsfolkDto->getHotkey(),
        ];
        $jsonData['emails'] = array_values(
            array_map(static function (Email $email) {
                return [
                    'email' => $email->getEmail(),
                    'type_email' => $email->getTypeEmail(),
                ];
            }, $kinsfolkDto->getEmails())
        );
        return $jsonData;
    }
}
