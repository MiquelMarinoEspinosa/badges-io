<?php

namespace Interactor\CommandHandler\UpdateBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Domain\Entity\Tenant\Tenant;
use Domain\Entity\Tenant\TenantRepository;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerException;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\UpdateBadge\ImageData\ImageData;

class UpdateBadgeCommandHandler implements CommandHandler
{
    /**
     * @var TenantRepository
     */
    private $tenantRepository;
    /**
     * @var ImageRepository
     */
    private $imageRepository;
    /**
     * @var BadgeRepository
     */
    private $badgeRepository;
    /**
     * @var BadgeDataTransformer
     */
    private $badgeDataTransformer;

    public function __construct(
        TenantRepository $tenantRepository,
        ImageRepository $imageRepository,
        BadgeRepository $badgeRepository,
        BadgeDataTransformer $badgeDataTransformer
    ) {
        $this->tenantRepository     = $tenantRepository;
        $this->imageRepository      = $imageRepository;
        $this->badgeRepository      = $badgeRepository;
        $this->badgeDataTransformer = $badgeDataTransformer;
    }

    /**
     * @param UpdateBadgeCommand $command
     *
     * @return mixed
     * @throws InvalidUpdateBadgeCommandHandlerException
     */
    public function handle($command)
    {
        $previousBadge  = $this->tryToFindBadgeByBadgeIdAndTenantId($command->id(), $command->tenantData()->id());
        $tenant         = $this->tryToFindTenantByTenantId($command->tenantData()->id());
        $updatedImage   = $this->tryToUpdateImage($previousBadge->image()->id(), $command->imageData());
        $updatedBadge   = $this->tryToUpdateBadge($command, $previousBadge, $tenant, $updatedImage);

        return $this->badgeDataTransformer->transform($updatedBadge);
    }

    /**
     * @param string $badgeId
     * @param string $tenantId
     *
     * @return Badge
     * @throws InvalidUpdateBadgeCommandHandlerException
     */
    private function tryToFindBadgeByBadgeIdAndTenantId($badgeId, $tenantId)
    {
        $aNullBadge = null;
        try {
            $badge = $this->badgeRepository->find($badgeId);
        } catch (\Exception $exception) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED
            );
        }

        if ($aNullBadge === $badge) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND
            );
        }

        if ($badge->tenant()->id() !== $tenantId) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN
            );
        }

        return $badge;
    }

    /**
     * @param string $tenantId
     *
     * @return Tenant
     * @throws InvalidUpdateBadgeCommandHandlerException
     */
    private function tryToFindTenantByTenantId($tenantId)
    {
        $aNullTenant = null;
        try {
            $tenant = $this->tenantRepository->find($tenantId);
        } catch (\Exception $exception) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED
            );
        }

        if ($aNullTenant === $tenant) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND
            );
        }

        return $tenant;
    }

    /**
     * @param string $imageId
     * @param ImageData $imageData
     *
     * @return Image
     * @throws InvalidUpdateBadgeCommandHandlerException
     */
    private function tryToUpdateImage($imageId, ImageData $imageData)
    {
        try {
            $image = $this->updateImage($imageId, $imageData);
            $this->imageRepository->persist($image);
        } catch (\Exception $exception) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED
            );
        }

        return $image;
    }

    /**
     * @param string $imageId
     * @param ImageData $imageData
     *
     * @return Image
     */
    private function updateImage($imageId, ImageData $imageData)
    {
        return new Image(
            $imageId,
            $imageData->name(),
            $imageData->width(),
            $imageData->height(),
            $imageData->format()
        );
    }

    /**
     * @param UpdateBadgeCommand $command
     * @param Badge $badge
     * @param Tenant $tenant
     * @param Image $image
     *
     * @return Badge
     * @throws InvalidUpdateBadgeCommandHandlerException
     */
    private function tryToUpdateBadge(UpdateBadgeCommand $command, Badge $badge, Tenant $tenant, Image $image)
    {
        try {
            $badge = $this->updateBadge($command, $badge, $tenant, $image);
            $this->badgeRepository->persist($badge);
        } catch (\Exception $exception) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED
            );
        }

        return $badge;
    }

    /**
     * @param UpdateBadgeCommand $command
     * @param Badge $badge
     * @param Tenant $tenant
     * @param Image $image
     *
     * @return Badge
     */
    private function updateBadge(UpdateBadgeCommand $command, Badge $badge, Tenant $tenant, Image $image)
    {
        return new Badge(
            $badge->id(),
            $command->name(),
            $command->description(),
            $command->isMultiTenant(),
            $tenant,
            $image
        );
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidUpdateBadgeCommandHandlerException
     */
    private function buildInvalidUpdateBadgeCommandHandlerException($statusCode)
    {
        return new InvalidUpdateBadgeCommandHandlerException($statusCode);
    }
}
