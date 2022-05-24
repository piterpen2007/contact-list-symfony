<?php

namespace EfTech\ContactList\ConsoleCommand;

use EfTech\ContactList\Service\SearchRecipientsService;
use EfTech\ContactList\Service\SearchRecipientsService\RecipientDto;
use EfTech\ContactList\Service\SearchRecipientsService\SearchRecipientsCriteria;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FindRecipient extends Command
{
    private SearchRecipientsService $searchRecipientsService;

    /**
     * @param SearchRecipientsService $searchRecipientsService
     */
    public function __construct(SearchRecipientsService $searchRecipientsService)
    {
        parent::__construct();
        $this->searchRecipientsService = $searchRecipientsService;
    }

    protected function configure()
    {
        $this->setName('contactList:find-recipient');
        $this->setDescription('Found recipient');
        $this->setHelp('Found recipient by criteria');
        $this->addOption('id_recipient','i', InputOption::VALUE_REQUIRED,'Found recipient id');
        $this->addOption('full_name','f', InputOption::VALUE_REQUIRED,'Found recipient full_name');
        $this->addOption('birthday','b', InputOption::VALUE_REQUIRED,'Found recipient birthday');
        $this->addOption('profession','p', InputOption::VALUE_REQUIRED,'Found recipient profession');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = $input->getOptions();
        $dtoCollection = $this->searchRecipientsService->search(
            (new SearchRecipientsCriteria())
                ->setIdRecipient($params['id_recipient'] ?? null)
                ->setFullName($params['full_name'] ?? null)
                ->setBirthday($params['birthday'] ?? null)
                ->setProfession($params['profession'] ?? null)
        );
        $jsonData = $this->buildJsonData($dtoCollection);
        $table = new Table($output);
        $table->setHeaders([
            'id_recipient',
            'full_name',
            'birthday',
            'profession'
        ]);

        $table->setRows($jsonData);
        $table->render();
        return self::SUCCESS;
    }

    /**
     * @param RecipientDto[] $dtoCollection
     *
     * @return array
     */
    private function buildJsonData(array $dtoCollection): array
    {
        $result = [];
        foreach ($dtoCollection as $recipientDto) {
            $result[] = [
                'id_recipient' => $recipientDto->getIdRecipient(),
                'full_name' => $recipientDto->getFullName(),
                'birthday' => $recipientDto->getBirthday()->format('d.m.Y'),
                'profession' => $recipientDto->getProfession(),
            ];
        }
        return $result;
    }



}