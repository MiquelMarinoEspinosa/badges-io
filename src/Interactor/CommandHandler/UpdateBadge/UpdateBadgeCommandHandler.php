<?php

namespace Interactor\CommandHandler\UpdateBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerException;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\UpdateBadge\ImageData\ImageData;

class UpdateBadgeCommandHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;
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
        UserRepository  $userRepository,
        ImageRepository $imageRepository,
        BadgeRepository $badgeRepository,
        BadgeDataTransformer $badgeDataTransformer
    ) {
        $this->userRepository       = $userRepository;
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
        $previousBadge  = $this->tryToFindBadgeByBadgeIdAndUserId($command->id(), $command->userData()->id());
        $user           = $this->tryToFindUserByUserId($command->userData()->id());
        $updatedImage   = $this->tryToUpdateImage($previousBadge->image()->id(), $command->imageData());
        $updatedBadge   = $this->tryToUpdateBadge($command, $previousBadge, $user, $updatedImage);

        return $this->badgeDataTransformer->transform($updatedBadge);
    }

    /**
     * @param string $badgeId
     * @param string $userId
     *
     * @return Badge
     * @throws InvalidUpdateBadgeCommandHandlerException
     */
    private function tryToFindBadgeByBadgeIdAndUserId($badgeId, $userId)
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

        if ($badge->user()->id() !== $userId) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN
            );
        }

        return $badge;
    }

    /**
     * @param string $userId
     *
     * @return User
     * @throws InvalidUpdateBadgeCommandHandlerException
     */
    private function tryToFindUserByUserId($userId)
    {
        $aNullUser = null;
        try {
            $user = $this->userRepository->find($userId);
        } catch (\Exception $exception) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED
            );
        }

        if ($aNullUser === $user) {
            throw $this->buildInvalidUpdateBadgeCommandHandlerException(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND
            );
        }

        return $user;
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
     * @param User $user
     * @param Image $image
     *
     * @return Badge
     * @throws InvalidUpdateBadgeCommandHandlerException
     */
    private function tryToUpdateBadge(UpdateBadgeCommand $command, Badge $badge, User $user, Image $image)
    {
        try {
            $badge = $this->updateBadge($command, $badge, $user, $image);
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
     * @param User  $user
     * @param Image $image
     *
     * @return Badge
     */
    private function updateBadge(UpdateBadgeCommand $command, Badge $badge, User $user, Image $image)
    {
        return new Badge(
            $badge->id(),
            $command->name(),
            $command->description(),
            $command->isMultiUser(),
            $user,
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
