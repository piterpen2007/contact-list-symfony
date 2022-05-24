<?php

namespace EfTech\ContactList\Controller;


use EfTech\ContactList\Service\SearchColleagueService;
use EfTech\ContactList\Service\SearchColleagueService\ColleagueDto;
use EfTech\ContactList\Service\SearchColleagueService\SearchColleagueCriteria;
use Psr\Log\LoggerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetColleaguesCollectionController extends AbstractController
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
     * @var SearchColleagueService
     */
    private SearchColleagueService $searchColleagueService;
    /** Логгер
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     * @param SearchColleagueService $searchColleagueService
     * @param ValidatorInterface $validator
     */
    public function __construct(
        LoggerInterface $logger,
        SearchColleagueService $searchColleagueService,
        \Symfony\Component\Validator\Validator\ValidatorInterface $validator
    ) {
        $this->logger = $logger;
        $this->searchColleagueService = $searchColleagueService;
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
                        'department' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect department']),
                            ]
                        ),
                        'position' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect position']),
                            ]
                        ),
                        'room_number' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect room_number']),
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
            $foundColleagues = $this->searchColleagueService->search(
                (new SearchColleagueCriteria())
                    ->setIdRecipient($params['id_recipient'] ?? null)
                    ->setFullName($params['full_name'] ?? null)
                    ->setBirthday($params['birthday'] ?? null)
                    ->setProfession($params['profession'] ?? null)
                    ->setDepartment($params['department'] ?? null)
                    ->setPosition($params['position'] ?? null)
                    ->setRoomNumber($params['room_number'] ?? null)
            );

            $httpCode = $this->buildHttpCode($foundColleagues);
            $result = $this->buildResult($foundColleagues);
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
     * @param array $foundColleagues
     * @return int
     */
    protected function buildHttpCode(array $foundColleagues): int
    {
        return 200;
    }

    /** Подготавливает данные для ответа
     * @param array $foundColleagues
     * @return array
     */
    protected function buildResult(array $foundColleagues): array
    {
        $result = [];
        foreach ($foundColleagues as $foundColleague) {
            $result[] = $this->serializeRecipient($foundColleague);
        }
        return $result;
    }

    /**
     * @param ColleagueDto $colleagueDto
     * @return array
     */
    final protected function serializeRecipient(ColleagueDto $colleagueDto): array
    {
        $jsonData =  [
            'id_recipient' => $colleagueDto->getIdRecipient(),
            'full_name' => $colleagueDto->getFullName(),
            'birthday' => $colleagueDto->getBirthday()->format('Y-m-d'),
            'profession' => $colleagueDto->getProfession(),
            'department' => $colleagueDto->getDepartment(),
            'position' => $colleagueDto->getPosition(),
            'room_number' => $colleagueDto->getRoomNumber()
        ];
        $jsonData['emails'] = array_values(
            array_map(static function ($email) {
                return [
                    'email' => $email->getEmail(),
                    'type_email' => $email->getTypeEmail(),
                ];
            }, $colleagueDto->getEmails())
        );
        return $jsonData;
    }
}
