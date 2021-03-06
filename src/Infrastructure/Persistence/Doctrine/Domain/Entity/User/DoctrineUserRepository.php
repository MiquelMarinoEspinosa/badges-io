<?php

namespace Infrastructure\Persistence\Doctrine\Domain\Entity\User;

use Doctrine\ORM\EntityManager;
use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;

class DoctrineUserRepository implements UserRepository
{
    /** @var EntityManager */
    protected $entityManager;

    /** @var \Doctrine\ORM\EntityRepository */
    protected $entityRepository;

    public function __construct($entityManager)
    {
        $this->entityManager    = $entityManager;
        $this->entityRepository = $this->entityManager->getRepository(User::class);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->entityRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserName($userName)
    {
        return $this->entityRepository->findOneBy(['userName' => $userName]);
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function persist(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush($user);
    }
}
