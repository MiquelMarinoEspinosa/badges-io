<?php

namespace Infrastructure\Persistence\Doctrine\Domain\Entity\Tenant;

use Domain\Entity\Tenant\Tenant;
use Domain\Entity\Tenant\TenantRepository;
use Domain\Entity\User\User;
use Infrastructure\Persistence\Doctrine\Domain\Entity\User\DoctrineUserRepository;

class DoctrineTenantRepository extends DoctrineUserRepository implements TenantRepository
{
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        /** @var User $anUser */
        $anUser = $this->entityRepository->find($id);

        return $this->buildTenantFromUser($anUser);
    }

    /**
     * @param User $anUser
     *
     * @return Tenant
     */
    private function buildTenantFromUser(User $anUser)
    {
        return new Tenant(
            $anUser->id(),
            $anUser->email(),
            $anUser->userName(),
            $anUser->passWord()
        );
    }
}
