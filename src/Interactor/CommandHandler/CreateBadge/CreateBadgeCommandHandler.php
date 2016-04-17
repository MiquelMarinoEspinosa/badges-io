<?php

namespace Interactor\CommandHandler\CreateBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;
use Domain\Service\IdGenerator;
use Domain\Service\ImageManager;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;

class CreateBadgeCommandHandler implements CommandHandler
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
     * @var IdGenerator
     */
    private $idGenerator;
    /**
     * @var ImageManager
     */
    private $imageManager;
    /**
     * @var BadgeDataTransformer
     */
    private $badgeDataTransformer;

    public function __construct(
        UserRepository          $userRepository,
        ImageRepository         $imageRepository,
        BadgeRepository         $badgeRepository,
        IdGenerator             $idGenerator,
        ImageManager            $imageManager,
        BadgeDataTransformer    $badgeDataTransformer
    ) {
        $this->userRepository       = $userRepository;
        $this->imageRepository      = $imageRepository;
        $this->badgeRepository      = $badgeRepository;
        $this->idGenerator          = $idGenerator;
        $this->imageManager         = $imageManager;
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
        $user = $this->tryToFindUserByUserId($command->userData()->id());
        $image  = $this->tryToPersistImage($command->imageData());
        $badge  = $this->tryToPersistBadge($command, $user, $image);

        return $this->badgeDataTransformer->transform($badge);
    }

    /**
     * @param string $userId
     *
     * @return User
     * @throws InvalidCreateBadgeCommandHandlerException
     */
    private function tryToFindUserByUserId($userId)
    {
        $aNullUser = null;
        try {
            $user = $this->userRepository->find($userId);
        } catch (\Exception $exception) {
            throw $this->buildInvalidCreateBadgeCommandHandlerException(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED
            );
        }

        if ($aNullUser === $user) {
            throw $this->buildInvalidCreateBadgeCommandHandlerException(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND
            );
        }

        return $user;
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
        $this->tryToPersistImageData($image);
        $this->tryToPersistImageToPath($imageData, $image->id());

        return $image;
    }

    /**
     * @param Image$image
     * @throws InvalidCreateBadgeCommandHandlerException
     */
    private function tryToPersistImageData(Image $image)
    {
        try {
            $this->imageRepository->persist($image);
        } catch (\Exception $exception) {
            throw $this->buildInvalidCreateBadgeCommandHandlerException(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED
            );
        }
    }

    /**
     * @param ImageData $imageData
     * @param string $imageId
     *
     * @throws InvalidCreateBadgeCommandHandlerException
     */
    private function tryToPersistImageToPath(ImageData $imageData, $imageId)
    {
        try {
            $this->imageManager->upload($imageData->path(), $imageId, $imageData->format());
        } catch (\Exception $exception) {
            throw $this->buildInvalidCreateBadgeCommandHandlerException(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED
            );
        }
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

    private function tryToPersistBadge($command, $user, $image)
    {
        $badge = $this->buildBadge($command, $user, $image);
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
     * @param User $user
     * @param Image $image
     *
     * @return Badge
     */
    private function buildBadge($command, $user, $image)
    {
        return new Badge(
            $this->idGenerator->generateId(),
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
     * @return InvalidCreateBadgeCommandHandlerException
     */
    private function buildInvalidCreateBadgeCommandHandlerException($statusCode)
    {
        return new InvalidCreateBadgeCommandHandlerException($statusCode);
    }
}
