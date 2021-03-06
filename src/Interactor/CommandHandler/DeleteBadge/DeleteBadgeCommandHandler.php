<?php

namespace Interactor\CommandHandler\DeleteBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Domain\Service\ImageManager;
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
    /**
     * @var ImageManager
     */
    private $imageManager;

    public function __construct(
        BadgeRepository $badgeRepository,
        ImageRepository $imageRepository,
        ImageManager    $imageManager
    ) {
        $this->badgeRepository  = $badgeRepository;
        $this->imageRepository  = $imageRepository;
        $this->imageManager     = $imageManager;
    }

    /**
     * @param DeleteBadgeCommand $command
     *
     * @return mixed
     */
    public function handle($command)
    {
        $badge = $this->tryToFindBadge($command->badgeId());
        $this->validateBadge($badge, $command->userId());
        $this->tryToRemoveTheBadge($badge);
        $this->tryToRemoveTheImage($badge->image());
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
     * @param string $userId
     *
     * @throws InvalidDeleteBadgeCommandHandlerException
     */
    private function validateBadge(Badge $badge, $userId)
    {
        $isNotMultiUser = false;
        if ($badge->isMultiUser() === $isNotMultiUser && $this->isUserForbidden($badge, $userId)) {
            throw $this->buildDeleteBadgeCommandHandlerException(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN
            );
        }
    }

    /**
     * @param Badge $badge
     * @param string $userId
     *
     * @return bool
     */
    private function isUserForbidden(Badge $badge, $userId)
    {
        return $badge->user()->id() !== $userId;
    }

    /**
     * @param Image $image
     *
     * @throws InvalidDeleteBadgeCommandHandlerException
     */
    private function tryToRemoveTheImage(Image $image)
    {
        $this->tryToRemoveImage($image);
        $this->tryToRemoveImageData($image);
    }


    /**
     * @param Image $image
     *
     * @throws InvalidDeleteBadgeCommandHandlerException
     */
    private function tryToRemoveImageData(Image $image)
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
     * @param Image $image
     *
     * @throws InvalidDeleteBadgeCommandHandlerException
     */
    private function tryToRemoveImage(Image $image)
    {
        try {
            $this->imageManager->remove($image->id(), $image->format());
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
