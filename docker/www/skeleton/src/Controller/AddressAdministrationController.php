<?php

namespace EfTech\ContactList\Controller;

use Doctrine\ORM\EntityManagerInterface;
use EfTech\ContactList\Exception\RuntimeException;
use EfTech\ContactList\Form\CreateAddressForm;
use EfTech\ContactList\Service\SearchColleagueService;
use EfTech\ContactList\Service\SearchColleagueService\SearchColleagueCriteria;
use EfTech\ContactList\Service\SearchCustomersService;
use EfTech\ContactList\Service\SearchCustomersService\SearchCustomersCriteria;
use EfTech\ContactList\Service\SearchKinsfolkService;
use EfTech\ContactList\Service\SearchKinsfolkService\SearchKinsfolkCriteria;
use EfTech\ContactList\Service\SearchRecipientsService;
use EfTech\ContactList\Service\SearchRecipientsService\SearchRecipientsCriteria;
use EfTech\ContactList\Service\ArrivalAddressService;
use EfTech\ContactList\Service\ArrivalNewAddressService\NewAddressDto;
use EfTech\ContactList\Service\SearchAddressService;
use EfTech\ContactList\Service\SearchAddressService\SearchAddressCriteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AddressAdministrationController extends AbstractController
{
    /** Сервис добавлениянового адреса
     * @var ArrivalAddressService
     */
    private ArrivalAddressService $arrivalAddressService;
    /** Сервис поиска адресов
     * @var SearchAddressService
     */
    private SearchAddressService $addressService;
    private SearchColleagueService $searchColleagueService;
    private SearchKinsfolkService $searchKinsfolkService;
    private SearchRecipientsService $searchRecipientsService;
    private SearchCustomersService $searchCustomersService;

    /**
     * Менеджер сущностей
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;


    /**
     * @param ArrivalAddressService $arrivalAddressService
     * @param SearchAddressService $addressService
     * @param SearchColleagueService $searchColleagueService
     * @param SearchKinsfolkService $searchKinsfolkService
     * @param SearchRecipientsService $searchRecipientsService
     * @param SearchCustomersService $searchCustomersService
     * @param EntityManagerInterface $em
     */
    public function __construct(
        ArrivalAddressService $arrivalAddressService,
        SearchAddressService $addressService,
        \EfTech\ContactList\Service\SearchColleagueService $searchColleagueService,
        \EfTech\ContactList\Service\SearchKinsfolkService $searchKinsfolkService,
        \EfTech\ContactList\Service\SearchRecipientsService $searchRecipientsService,
        \EfTech\ContactList\Service\SearchCustomersService $searchCustomersService,
        \Doctrine\ORM\EntityManagerInterface $em
    ) {
        $this->arrivalAddressService = $arrivalAddressService;
        $this->addressService = $addressService;
        $this->searchColleagueService = $searchColleagueService;
        $this->searchKinsfolkService = $searchKinsfolkService;
        $this->searchRecipientsService = $searchRecipientsService;
        $this->searchCustomersService = $searchCustomersService;
        $this->em = $em;
    }


    public function __invoke(Request $request): Response
    {

            $formAddress = $this->createForm(CreateAddressForm::class);
            $formAddress->handleRequest($request);

            if ($formAddress->isSubmitted() && $formAddress->isValid()) {
                $this->createAddress($formAddress->getData());
                $formAddress = $this->createForm(CreateAddressForm::class);
            }


            $template = 'address.administration.twig';

            $dtoAddressesCollection = $this->addressService->search(new SearchAddressCriteria());
            $recipients = $this->searchRecipientsService->search(new SearchRecipientsCriteria());
            $colleagues = $this->searchColleagueService->search(new SearchColleagueCriteria());
            $customers = $this->searchCustomersService->search(new SearchCustomersCriteria());
            $kinsfolk = $this->searchKinsfolkService->search(new SearchKinsfolkCriteria());
            $dtoContactsCollection = array_merge($recipients, $colleagues, $customers, $kinsfolk);

            $context = [
                'form_address' => $formAddress,
                'Addresses' => $dtoAddressesCollection,
                'contacts' => $dtoContactsCollection
            ];
        return $this->renderForm($template, $context);
    }

//    /** Результат создания адресов
//     *
//     * @param ServerRequestInterface $request
//     * @return array - данные о ошибках у форм создания адресов
//     */
//    private function creationOfAddress(ServerRequestInterface $request): array
//    {
//        $dataToCreate = [];
//        parse_str($request->getBody(), $dataToCreate);
//
//        $result = [
//            'formValidationResults' => [
//                'address' => [],
//            ]
//        ];
//        $result['formValidationResults']['address'] = $this->validateAddresses($dataToCreate);
//        if (0 === count($result['formValidationResults']['address'])) {
//            $this->createAddress($dataToCreate);
//        } else {
//            $result['addressData'] = $dataToCreate;
//        }
//        return $result;
//    }
    /** Создаёт адрес
     * @param array $dataToCreate
     * @return void
     */
    private function createAddress(array $dataToCreate): void
    {
        try {
            $this->em->beginTransaction();

            $this->arrivalAddressService->registerAddress(
                new NewAddressDto(
                    $dataToCreate['id_recipient'],
                    $dataToCreate['address'],
                    $dataToCreate['status']
                )
            );
            $this->em->flush();
            $this->em->commit();
        } catch (Throwable $e) {
            $this->em->rollback();

            throw new RuntimeException(
                'Ошибка при добавлении нового адреса: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
