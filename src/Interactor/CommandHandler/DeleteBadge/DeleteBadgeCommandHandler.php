<?php

namespace Interactor\CommandHandler\DeleteBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandHandlerException;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandHandlerExceptionCode;

class DeleteBadgeCommandHandler implements CommandHandler
{
    /**
     * @var BadgeRepository
     */
    private $badgeRepository;

    /**
     * @var ImageRepository
     */
    private $imageRepository;

    public function __construct(BadgeRepository $badgeRepository, ImageRepository $imageRepository)
    {
        $this->badgeRepository = $badgeRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * @param DeleteBadgeCommand $command
     *
     * @return mixed
     */
    public function handle($command)
    {
        $badge = $this->tryToFindBadge($command->badgeId());
        $this->validateBadge($badge, $command->tenantId());
        $this->tryToRemoveTheImage($badge->image());
        $this->tryToRemoveTheBadge($badge);
    }

    /**
     * @param string $badgeId
     *
     * @return Badge
     * @throws InvalidDeleteBadgeCommandHandlerException
     */
    private function tryToFindBadge($badgeId)
    {
        $aNullBadge = null;
        try {
            $badge = $this->badgeRepository->find($badgeId);
        } catch (\Exception $exception) {
            throw $this->buildDeleteBadgeCommandHandlerException(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED
            );
        }

        if ($aNullBadge === $badge) {
            throw $this->buildDeleteBadgeCommandHandlerException(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND
            );
        }

        return $badge;
    }

    /**
     * @param Badge $badge
     * @param string $tenantId
     *
     * @throws InvalidDeleteBadgeCommandHandlerException
     */
    private function validateBadge(Badge $badge, $tenantId)
    {
        $isNotMultiTenant = false;
        if ($badge->isMultiTenant() === $isNotMultiTenant && $this->isTenantForbidden($badge, $tenantId)) {
            throw $this->buildDeleteBadgeCommandHandlerException(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN
            );
        }
    }

    /**
     * @param Badge $badge
     * @param string $tenantId
     *
     * @return bool
     */
    private function isTenantForbidden(Badge $badge, $tenantId)
    {
        return $badge->tenant()->id() !== $tenantId;
    }

    /**
     * @param Image $image
     *
     * @throws InvalidDeleteBadgeCommandHandlerException
     */
    private function tryToRemoveTheImage(Image $image)
    {
        try {
            $this->imageRepository->remove($image);
        } catch (\Exception $exception) {
            throw $this->buildDeleteBadgeCommandHandlerException(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED
            );
        }
    }

    /**
     * @param Badge $badge
     *
     * @throws InvalidDeleteBadgeCommandHandlerException
     */
    private function tryToRemoveTheBadge(Badge $badge)
    {
        try {
            $this->badgeRepository->remove($badge);
        } catch (\Exception $exception) {
            throw $this->buildDeleteBadgeCommandHandlerException(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED
            );
        }
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidDeleteBadgeCommandHandlerException
     */
    private function buildDeleteBadgeCommandHandlerException($statusCode)
    {
        return new InvalidDeleteBadgeCommandHandlerException($statusCode);
    }
}
