<?php

namespace EfTech\ContactList\Controller;

use EfTech\ContactList\Entity\Customer;
use Psr\Log\LoggerInterface;
use EfTech\ContactList\Service\SearchCustomersService\CustomerDto;
use EfTech\ContactList\Service\SearchCustomersService\SearchCustomersCriteria;
use EfTech\ContactList\Service\SearchCustomersService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class GetCustomersCollectionController extends AbstractController
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
     * @var SearchCustomersService
     */
    private SearchCustomersService $searchCustomersService;
    /** Логгер
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     * @param SearchCustomersService $searchCustomersService
     * @param ValidatorInterface $validator
     */
    public function __construct(
        LoggerInterface $logger,
        SearchCustomersService $searchCustomersService,
        \Symfony\Component\Validator\Validator\ValidatorInterface $validator
    ) {
        $this->logger = $logger;
        $this->searchCustomersService = $searchCustomersService;
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
                        'contract_number' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect contract_number']),
                            ]
                        ),
                        'average_transaction_amount' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect average_transaction_amount']),
                            ]
                        ),
                        'discount' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect discount']),
                            ]
                        ),
                        'time_to_call' => new Assert\Optional(
                            [
                                new Assert\Type(['type' => 'string','message' => 'incorrect time_to_call']),
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
        $this->logger->info("Ветка customer");

        $resultOfParamValidation = $this->validateQueryParams($request);

        if (null === $resultOfParamValidation) {
            $params = array_merge($request->query->all(), $request->attributes->all());
            $foundCustomers = $this->searchCustomersService->search(
                (new SearchCustomersCriteria())
                    ->setIdRecipient($params['id_recipient'] ?? null)
                    ->setFullName($params['full_name'] ?? null)
                    ->setBirthday($params['birthday'] ?? null)
                    ->setProfession($params['profession'] ?? null)
                ->setContactNumber($params['contract_number'] ?? null)
                ->setAverageTransactionAmount($params['average_transaction_amount'] ?? null)
                ->setDiscount($params['discount'] ?? null)
                ->setTimeToCall($params['time_to_call'] ?? null)
            );
            $httpCode = $this->buildHttpCode($foundCustomers);
            $result = $this->buildResult($foundCustomers);
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
     * @param array $foundCustomers
     * @return int
     */
    protected function buildHttpCode(array $foundCustomers): int
    {
        return 200;
    }

    /** Подготавливает данные для ответа
     * @param array $foundCustomers
     * @return array|Customer
     */
    protected function buildResult(array $foundCustomers)
    {
        $result = [];
        foreach ($foundCustomers as $foundCustomer) {
            $result[] = $this->serializeCustomer($foundCustomer);
        }
        return $result;
    }


    /**
     * @param CustomerDto $customerDto
     * @return array|Customer
     */
    final protected function serializeCustomer(CustomerDto $customerDto): array
    {
        $jsonData =  [
            'id_recipient' => $customerDto->getIdRecipient(),
            'full_name' => $customerDto->getFullName(),
            'birthday' => $customerDto->getBirthday()->format('d.m.Y'),
            'profession' => $customerDto->getProfession(),
            'contract_number' => $customerDto->getContactNumber(),
            'average_transaction_amount' => $customerDto->getAverageTransactionAmount(),
            'discount' => $customerDto->getDiscount(),
            'time_to_call' => $customerDto->getTimeToCall(),
        ];

        $jsonData['emails'] = array_values(
            array_map(static function ($email) {
                return [
                    'email' => $email->getEmail(),
                    'type_email' => $email->getTypeEmail(),
                ];
            }, $customerDto->getEmails())
        );
        return $jsonData;
    }
}
