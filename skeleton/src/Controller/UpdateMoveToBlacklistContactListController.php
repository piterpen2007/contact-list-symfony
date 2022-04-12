<?php

namespace EfTech\ContactList\Controller;

use Doctrine\ORM\EntityManagerInterface;
use EfTech\ContactList\Service\MoveToBlacklistContactListService;
use EfTech\ContactList\Service\MoveToBlacklistService\Exception\ContactListNotFoundException;
use EfTech\ContactList\Service\MoveToBlacklistService\Exception\RuntimeException;
use EfTech\ContactList\Service\MoveToBlacklistService\MoveToBlacklistDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateMoveToBlacklistContactListController extends AbstractController
{

    /**
     * @var MoveToBlacklistContactListService
     */
    private MoveToBlacklistContactListService $moveToBlacklistContactListService;

    /**
     * Менеджер сущностей
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;



    /**
     * @param MoveToBlacklistContactListService $moveToBlacklistContactListService
     * @param EntityManagerInterface $em
     */
    public function __construct(
        MoveToBlacklistContactListService $moveToBlacklistContactListService,
        \Doctrine\ORM\EntityManagerInterface $em
    ) {
        $this->moveToBlacklistContactListService = $moveToBlacklistContactListService;
        $this->em = $em;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $this->em->beginTransaction();

            $attributes = $request->attributes->all();
            if (false === array_key_exists('id_recipient', $attributes)) {
                throw new RuntimeException('there is no information about the id of the text document');
            }
            $resultDto = $this->moveToBlacklistContactListService->move($attributes['id_recipient']);
            $httpCode = 200;
            $jsonData = $this->buildJsonData($resultDto);
            $this->em->flush();
            $this->em->commit();
        } catch (ContactListNotFoundException $e) {
            $this->em->rollback();
            $httpCode = 404;
            $jsonData = ['status' => 'fail', 'message' => $e->getMessage()];
        } catch (Throwable $e) {
            $this->em->rollback();
            $httpCode = 500;
            $jsonData = ['status' => 'fail', 'message' => $e->getMessage()];
        }

        return $this->json($jsonData, $httpCode);
    }

    /** Подготавливает данные для успешного ответа на основе dto сервиса
     * @param MoveToBlacklistDto $resultDto
     * @return array
     */
    private function buildJsonData(MoveToBlacklistDto $resultDto): array
    {
        return [
            'blacklist' => $resultDto->isBlackList()
        ];
    }
}
