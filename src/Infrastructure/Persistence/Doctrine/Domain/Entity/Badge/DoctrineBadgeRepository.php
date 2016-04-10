<?php

namespace Infrastructure\Persistence\Doctrine\Domain\Entity\Badge;

use Doctrine\ORM\EntityManager;
use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\User\User;

class DoctrineBadgeRepository implements BadgeRepository
{
    /** @var EntityManager */
    private $entityManager;

    /** @var \Doctrine\ORM\EntityRepository */
    private $entityRepository;

    public function __construct($entityManager)
    {
        $this->entityManager    = $entityManager;
        $this->entityRepository = $this->entityManager->getRepository(Badge::class);
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Badge $badge)
    {
        $this->entityManager->persist($badge);
        $this->entityManager->flush($badge);
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
    public function remove(Badge $badge)
    {
        $this->entityManager->remove($badge);
        $this->entityManager->flush($badge);
    }

    /**
     * {@inheritdoc}
     */
    public function findByUser(User $user)
    {
        return $this->entityRepository->findBy(['user' => $user]);
    }

    /**
     * {@inheritdoc}
     */
    public function findMultiUser()
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('badges');

        return $queryBuilder
            ->where(
                $queryBuilder->expr()->eq('isMultiUser', 1)
            )->getQuery()
             ->getResult();
    }
}
