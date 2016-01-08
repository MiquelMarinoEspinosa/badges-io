<?php

namespace Interactor\CommandHandler\ListBadges;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeCollectionDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Tenant\Tenant;
use Domain\Entity\Tenant\TenantRepository;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerExceptionCode;

class ListBadgesCommandHandler implements CommandHandler
{
    /**
     * @var BadgeRepository
     */
    private $badgeRepository;

    /**
     * @var TenantRepository
     */
    private $tenantRepository;

    /**
     * @var BadgeCollectionDataTransformer
     */
    private $badgeCollectionDataTransformer;

    public function __construct(
        BadgeRepository                $badgeRepository,
        TenantRepository               $tenantRepository,
        BadgeCollectionDataTransformer $badgeCollectionDataTransformer
    ) {
        $this->badgeRepository                = $badgeRepository;
        $this->tenantRepository               = $tenantRepository;
        $this->badgeCollectionDataTransformer = $badgeCollectionDataTransformer;
    }

    /**
     * @param ListBadgesCommand $command
     *
     * @return mixed
     */
    public function handle($command)
    {
        $badgesByTenant    = $this->tryToFindBadgesByTenant($command->tenantId());
        $badgesMultiTenant = $this->tryToFindMultiTenantBadges();

        return $this->badgeCollectionDataTransformer->transform(array_merge($badgesByTenant, $badgesMultiTenant));
    }

    /**
     * @param string $tenantId
     *
     * @return Badge[]
     * @throws InvalidListBadgesCommandHandlerException
     */
    private function tryToFindBadgesByTenant($tenantId)
    {
        $tenant = $this->tryToFindTenantByTenantId($tenantId);
        try {
            $badgesByTenant = $this->badgeRepository->findByTenant($tenant);
        } catch (\Exception $exception) {
            throw $this->buildListBadgesCommandHandlerException(
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }

        return $badgesByTenant;
    }

    /**
     * @param string $tenantId
     *
     * @return Tenant
     * @throws InvalidListBadgesCommandHandlerException
     */
    private function tryToFindTenantByTenantId($tenantId)
    {
        $aNullTenant = null;
        try {
            $tenant = $this->tenantRepository->find($tenantId);
        } catch (\Exception $exception) {
            throw $this->buildListBadgesCommandHandlerException(
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }

        if ($aNullTenant === $tenant) {
            throw $this->buildListBadgesCommandHandlerException(
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND
            );
        }

        return $tenant;
    }

    /**
     * @return Badge[]
     * @throws InvalidListBadgesCommandHandlerException
     */
    private function tryToFindMultiTenantBadges()
    {
        try {
            $badgesMultiTenant = $this->badgeRepository->findMultiTenant();
        } catch (\Exception $exception) {
            throw $this->buildListBadgesCommandHandlerException(
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }


        return $badgesMultiTenant;
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidListBadgesCommandHandlerException
     */
    private function buildListBadgesCommandHandlerException($statusCode)
    {
        return new InvalidListBadgesCommandHandlerException($statusCode);
    }
}
