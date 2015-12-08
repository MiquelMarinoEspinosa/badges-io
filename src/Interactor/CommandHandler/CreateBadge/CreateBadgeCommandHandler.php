<?php

namespace Interactor\CommandHandler\CreateBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Domain\Entity\Tenant\Tenant;
use Domain\Entity\Tenant\TenantRepository;
use Domain\Service\IdGenerator;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;

class CreateBadgeCommandHandler implements CommandHandler
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
     * @var IdGenerator
     */
    private $idGenerator;
    /**
     * @var BadgeDataTransformer
     */
    private $badgeDataTransformer;

    public function __construct(
        TenantRepository $tenantRepository,
        ImageRepository $imageRepository,
        BadgeRepository $badgeRepository,
        IdGenerator $idGenerator,
        BadgeDataTransformer $badgeDataTransformer
    ) {
        $this->tenantRepository     = $tenantRepository;
        $this->imageRepository      = $imageRepository;
        $this->badgeRepository      = $badgeRepository;
        $this->idGenerator          = $idGenerator;
        $this->badgeDataTransformer = $badgeDataTransformer;
    }

    /**
     * @param CreateBadgeCommand $command
     *
     * @return mixed
     * @throws InvalidCreateBadgeCommandHandlerException
     */
    public function handle($command)
    {
        $tenant = $this->tryToFindTenantByTenantId($command->tenantData()->id());
        $image  = $this->tryToPersistImage($command->imageData());
        $badge  = $this->tryToPersistBadge($command, $tenant, $image);

        return $this->badgeDataTransformer->transform($badge);
    }

    /**
     * @param string $tenantId
     *
     * @return Tenant
     * @throws InvalidCreateBadgeCommandHandlerException
     */
    private function tryToFindTenantByTenantId($tenantId)
    {
        $aNullTenant = null;
        try {
            $tenant = $this->tenantRepository->find($tenantId);
        } catch (\Exception $exception) {
            throw $this->buildInvalidCreateBadgeCommandHandlerException(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED
            );
        }

        if ($aNullTenant === $tenant) {
            throw $this->buildInvalidCreateBadgeCommandHandlerException(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND
            );
        }

        return $tenant;
    }

    /**
     * @param ImageData $imageData
     *
     * @return Image
     * @throws InvalidCreateBadgeCommandHandlerException
     */
    private function tryToPersistImage($imageData)
    {
        $image = $this->buildImage($imageData);
        try {
            $this->imageRepository->persist($image);
        } catch (\Exception $exception) {
            throw $this->buildInvalidCreateBadgeCommandHandlerException(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED
            );
        }

        return $image;
    }

    /**
     * @param ImageData $imageData
     *
     * @return Image
     */
    private function buildImage($imageData)
    {
        return new Image(
            $this->idGenerator->generateId(),
            $imageData->name(),
            $imageData->width(),
            $imageData->height(),
            $imageData->format()
        );
    }

    private function tryToPersistBadge($command, $tenant, $image)
    {
        $badge = $this->buildBadge($command, $tenant, $image);
        try {
            $this->badgeRepository->persist($badge);
        } catch (\Exception $exception) {
            throw $this->buildInvalidCreateBadgeCommandHandlerException(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED
            );
        }

        return $badge;
    }

    /**
     * @param CreateBadgeCommand $command
     * @param Tenant $tenant
     * @param Image $image
     *
     * @return Badge
     */
    private function buildBadge($command, $tenant, $image)
    {
        return new Badge(
            $this->idGenerator->generateId(),
            $command->name(),
            $command->description(),
            $command->isMultiTenant(),
            [$tenant],
            $image
        );
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidCreateBadgeCommandHandlerException
     */
    private function buildInvalidCreateBadgeCommandHandlerException($statusCode)
    {
        return new InvalidCreateBadgeCommandHandlerException($statusCode);
    }
}
