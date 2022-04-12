<?php

namespace EfTech\ContactList\Controller;

use Doctrine\ORM\EntityManagerInterface;
use EfTech\ContactList\Entity\Recipient;
use EfTech\ContactList\Service\ArrivalAddressService;
use EfTech\ContactList\Service\ArrivalNewAddressService\NewAddressDto;
use EfTech\ContactList\Service\ArrivalNewAddressService\ResultRegisterNewAddressDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateAddressController extends AbstractController
{
    /**
     * Сервис валидации
     *
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    private ArrivalAddressService $addressService;
    /**
     * Менеджер сущностей
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;


    /**
     * @param ArrivalAddressService $addressService
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ArrivalAddressService $addressService,
        \Doctrine\ORM\EntityManagerInterface $em,
        \Symfony\Component\Validator\Validator\ValidatorInterface $validator
    ) {
        $this->addressService = $addressService;
        $this->em = $em;
        $this->validator = $validator;
    }


    public function __invoke(Request $request): Response
    {
        try {
            $this->em->beginTransaction();
            $requestData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $validationResult = $this->validateData($requestData);

            if (0 === count($validationResult)) {
                // Создаю dto с входными данными
                $responseDto = $this->runService($requestData);
                $httpCode = 201;
                $jsonData = $this->buildJsonData($responseDto);
            } else {
                $httpCode = 400;
                $jsonData = ['status' => 'fail','message' => implode('.', $validationResult)];
            }
            $this->em->flush();
            $this->em->commit();
        } catch (\Throwable $e) {
            $this->em->rollback();
            $httpCode = 500;
            $jsonData = ['status' => 'fail','message' => $e->getMessage()];
        }

        return $this->json($jsonData,$httpCode);
    }

    private function runService(array $requestData): ResultRegisterNewAddressDto
    {
        $requestDto = new NewAddressDto(
            $requestData['id_recipient'],
            $requestData['address'],
            $requestData['status']
        );

        return $this->addressService->registerAddress($requestDto);
    }

    /** Формирует результаты для ответа на основе dto
     * @param ResultRegisterNewAddressDto $responseDto
     * @return array
     */
    private function buildJsonData(ResultRegisterNewAddressDto $responseDto): array
    {
        $jsonDataIdRecipient = array_values(
            array_map(
                static function (Recipient $recipient) {
                    return $recipient->getIdRecipient();
                },
                $responseDto->getIdRecipient()
            )
        );

        $jsonData =  [
            'id_address' => $responseDto->getIdAddress(),
            'id_recipient' => $jsonDataIdRecipient,
            'address' => $responseDto->getAddress(),
            'status' => $responseDto->getStatus()
        ];

            return $jsonData;
    }

    /** Валидирует входные данные
     * @param $requestData
     * @return array
     * @throws \Exception
     */
    private function validateData($requestData): array
    {
        $constraints = [
            new Assert\Type(['type' => 'array', 'message' => 'Данные о новом адресе не являются масивом']),
            new Assert\Collection([
                'allowExtraFields'     => false,
                'allowMissingFields'   => false,
                'missingFieldsMessage' => 'Отсутствует обязательное поле: {{ field }}',
                'extraFieldsMessage'   => 'Есть лишние поля: {{ field }}',
                'fields'               => [
                    'address'          => [
                        new Assert\Type(['type' => 'string', 'message' => 'адрес должен быть строкой']),
                        new Assert\NotBlank([
                            'message'    => 'адрес не может быть пустой строкой',
                            'normalizer' => 'trim'
                        ]),
                        new Assert\Length([
                            'min'        => 1,
                            'max'        => 255,
                            'minMessage' => 'Некорректная длина адреса. Необходимо {{ limit }} символов',
                            'maxMessage' => 'Некорректная длина адреса. Максимальное количество {{ limit }} символов'
                        ])
                    ],
                    'status'           => [
                        new Assert\Type(['type' => 'string', 'message' => 'статус должен быть строкой']),
                        new Assert\NotBlank([
                            'message'    => 'статус не может быть пустой строкой',
                            'normalizer' => 'trim'
                        ]),
                        new Assert\Length([
                            'min'        => 1,
                            'max'        => 255,
                            'minMessage' => 'Некорректная длина статуса. Необходимо {{ limit }} символов',
                            'maxMessage' => 'Некорректная длина статуса. Максимальное количество {{ limit }} символов'
                        ])
                    ],
                    'id_recipient' => [
                        new Assert\Type(['type' => 'array', 'message' => 'Список id контактов должен быть массивом']),
                        new Assert\Count(
                            ['min' => 1, 'minMessage' => 'Список id контактов должен содержать хотя бы один элемент']
                        ),
                        new Assert\All([
                            new Assert\Type(
                                [
                                    'type'    => 'int',
                                    'message' => 'Список id контактов содержит некорректные идентификаторы'
                                ]
                            )
                        ])
                    ]
                ]
            ]),
        ];

        $err = $this->validator->validate($requestData, $constraints);

        return array_map(static function ($v) {
            return $v->getMessage();
        }, $err->getIterator()->getArrayCopy());

    }
}
