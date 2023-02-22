<?php

namespace App\Repository;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;



class ChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Chat::class);
    }


    public function findPersonalChat(User $firstUser, User $secondUser)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->innerJoin('c.users', 'u')
            ->andWhere('u.id = :firstUser')
            ->andWhere('u.id = :secondUser')

            ->setParameter('firstUser', $firstUser)
            ->setParameter('secondUser', $secondUser)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findChatsWithUser(User $user)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->innerJoin('c.users', 'u')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findChats()
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->addSelect('u')
            ->leftJoin('c.users', 'u')
        ;

        return $qb->getQuery()->getResult();
    }
}