<?php
namespace EfTech\ContactList\Form;

use EfTech\ContactList\Service\SearchColleagueService;
use EfTech\ContactList\Service\SearchColleagueService\SearchColleagueCriteria;
use EfTech\ContactList\Service\SearchCustomersService;
use EfTech\ContactList\Service\SearchCustomersService\SearchCustomersCriteria;
use EfTech\ContactList\Service\SearchKinsfolkService;
use EfTech\ContactList\Service\SearchKinsfolkService\SearchKinsfolkCriteria;
use EfTech\ContactList\Service\SearchRecipientsService;
use EfTech\ContactList\Service\SearchRecipientsService\SearchRecipientsCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as FormElement;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *  Реализация настройки формы, описывающая создание книги
 */
class CreateAddressForm extends AbstractType
{
    private SearchRecipientsService $searchRecipientsService;
    private SearchKinsfolkService $searchKinsfolkService;
    private SearchCustomersService $searchCustomersService;
    private SearchColleagueService $searchColleagueService;

    /**
     * @param SearchRecipientsService $searchRecipientsService
     * @param SearchKinsfolkService $searchKinsfolkService
     * @param SearchCustomersService $searchCustomersService
     * @param SearchColleagueService $searchColleagueService
     */
    public function __construct(
        SearchRecipientsService $searchRecipientsService,
        SearchKinsfolkService $searchKinsfolkService,
        SearchCustomersService $searchCustomersService,
        SearchColleagueService $searchColleagueService
    ) {
        $this->searchRecipientsService = $searchRecipientsService;
        $this->searchKinsfolkService = $searchKinsfolkService;
        $this->searchCustomersService = $searchCustomersService;
        $this->searchColleagueService = $searchColleagueService;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $recipients = $this->searchRecipientsService->search(new SearchRecipientsCriteria());
        $colleagues = $this->searchColleagueService->search(new SearchColleagueCriteria());
        $customers = $this->searchCustomersService->search(new SearchCustomersCriteria());
        $kinsfolk = $this->searchKinsfolkService->search(new SearchKinsfolkCriteria());
        $dtoContactsCollection = array_merge($recipients, $colleagues, $customers, $kinsfolk);


        $builder->add('id_recipient', FormElement\ChoiceType::class, [
            'required' => true,
            'multiple' => true,
            'label' => 'Информация о контакте',
            'choices' => $dtoContactsCollection,
            'choice_label' => static function($dtoContactsCollection):string {
                return $dtoContactsCollection->getIdRecipient() . ' ' . $dtoContactsCollection->getFullName();
            },
            'choice_value' => static function($dtoContactsCollection):string {
                return $dtoContactsCollection->getIdRecipient();
            },
            'priority' => 200
        ])->add('address', FormElement\TextType::class, [
            'required' => true,
            'label' => 'Адрес',
            'priority' => 300,
            'constraints' => [
                new Assert\Type([
                    'type' => 'string',
                    'message' => 'Данные о адресе должны быть строкой'
                ]),
                new Assert\NotBlank([
                    'normalizer' => 'trim',
                    'message' => 'Адрес не может быть пустым'
                ]),
                new Assert\Length([
                    'min' => 1,
                    'max' => 255,
                    'minMessage' => 'Минимальная длина адреса должна быть не меньше одного символа',
                    'maxMessage' => 'Адрес не может быть длинее {{limit}} символов'
                ])
            ]
        ])->add('status',FormElement\ChoiceType::class,[
            'required' => true,
            'label' => 'Статус адреса',
            'choices' => ['Work' => 'Work','Home' => 'Home'],
            'priority' => 200
        ])->add('submit', FormElement\SubmitType::class, [
            'label' => 'Добавить',
            'priority' => 100
        ])->setMethod('POST');

        $builder->get('id_recipient')->addModelTransformer(new CallbackTransformer(
            static function( $recipientIdList) {
                return $recipientIdList;
            },
            static function( $recipientIdList) {
                return array_map(static function($dtoContactsCollection) {
                    return $dtoContactsCollection->getIdRecipient();
                },$recipientIdList);
            }
        ));

        parent::buildForm($builder, $options);
    }

}