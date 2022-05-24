<?php

namespace EfTech\ContactList\Repository;

use Doctrine\ORM\EntityRepository;
use EfTech\ContactList\Entity\UserRepositoryInterface;
use EfTech\ContactList\Exception\RuntimeException;
use EfTech\ContactList\Entity\User;

class UserDoctrineRepository extends EntityRepository implements
    UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findUserByLogin(string $login): ?User
    {
        $entities = $this->findBy(['login' => $login]);
        $countEntities = count($entities);

        if ($countEntities > 1) {
            throw new RuntimeException('Найдены пользователи с дублирующимися логинами');
        }

        return 0 === $countEntities ? null : current($entities);
    }

    /**
     * @inheritDoc
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }
}
