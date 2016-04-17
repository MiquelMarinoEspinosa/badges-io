<?php

namespace Test\Interactor\CommandHandler\DeleteBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Domain\Service\ImageManager;
use Infrastructure\Persistence\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\Image\InMemoryImageRepository;
use Interactor\CommandHandler\DeleteBadge\DeleteBadgeCommand;
use Interactor\CommandHandler\DeleteBadge\DeleteBadgeCommandHandler;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandHandlerException;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandHandlerExceptionCode;
use Test\Domain\Entity\Badge\FakeBadgeBuilder;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageBuilder;
use Test\Domain\Entity\Image\FakeImageRepositoryThrownException;
use Test\Domain\Entity\User\FakeUserBuilder;
use Test\Domain\Service\FakeImageManager;
use Test\Domain\Service\FakeImageManagerThrownException;

class DeleteBadgeCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_ID            = '1234';
    const BADGE_ID_NOT_EXISTS = '43321';
    const BADGE_NAME          = 'Badge Name';
    const BADGE_DESCRIPTION   = 'BADGE_DESCRIPTION';
    const BADGE_IS_MULTI_USER = false;
    const USER_ID             = '4321';
    const USER_ID_NOT_EXISTS  = '56789';
    const USER_EMAIL          = 'userMail@badges.com';
    const USER_PASSWORD       = 'B3fr33';
    const IMAGE_ID            = '4567';
    const IMAGE_NAME          = 'Image Name';
    const IMAGE_WIDTH         = 45;
    const IMAGE_HEIGHT        = 45;
    const IMAGE_FORMAT        = 'jpeg';
    const USER_USERNAME       = 'userName';

    /**
     * @test
     */
    public function exceptionRepositoryWhenFindBadgeShouldThrownExceptionBadgeNotFoundStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                FakeBadgeRepositoryThrownException::FIND_THROW_EXCEPTION,
                $this->buildDefaultBadges()
            );

            $commandHandler  = $this->buildDeleteBadgeCommandHandler(
                $badgeRepository,
                $this->buildImageRepository([$this->buildDefaultImage()]),
                $this->buildImageManager()
            );
            $command = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::USER_ID);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandHandlerException $invalidDeleteBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED,
                $invalidDeleteBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function badgeNotFoundWhenFindBadgeShouldThrownExceptionBadgeNotFoundStatusCode()
    {
        try {
            $commandHandler  = $this->buildDeleteBadgeCommandHandler(
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildImageRepository([$this->buildDefaultImage()]),
                $this->buildImageManager()
            );
            $command = $this->buildDeleteBadgeCommand(static::BADGE_ID_NOT_EXISTS, static::USER_ID);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandHandlerException $invalidDeleteBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND,
                $invalidDeleteBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function badgeFoundButNotValidUserShouldThrownExceptionUserNotValidStatusCode()
    {
        try {
            $commandHandler  = $this->buildDeleteBadgeCommandHandler(
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildImageRepository([$this->buildDefaultImage()]),
                $this->buildImageManager()
            );
            $command = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::USER_ID_NOT_EXISTS);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandHandlerException $invalidDeleteBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN,
                $invalidDeleteBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenRemoveImageShouldThrownExceptionBadgeNotRemovedStatusCode()
    {
        try {
            $imageRepository = $this->buildFakeImageRepositoryThrownException(
                FakeBadgeRepositoryThrownException::REMOVE_THROW_EXCEPTION,
                [$this->buildDefaultImage()]
            );
            $commandHandler  = $this->buildDeleteBadgeCommandHandler(
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $imageRepository,
                $this->buildImageManager()
            );
            $command = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::USER_ID);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandHandlerException $invalidDeleteBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED,
                $invalidDeleteBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenRemoveBadgeShouldThrownExceptionBadgeNotRemovedStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                FakeBadgeRepositoryThrownException::REMOVE_THROW_EXCEPTION,
                $this->buildDefaultBadges()
            );
            $commandHandler  = $this->buildDeleteBadgeCommandHandler(
                $badgeRepository,
                $this->buildImageRepository([$this->buildDefaultImage()]),
                $this->buildImageManager()
            );
            $command = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::USER_ID);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandHandlerException $invalidDeleteBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED,
                $invalidDeleteBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionImageManagerWhenRemoveShouldThrownExceptionBadgeNotCreatedStatusCode()
    {
        try {
            $imageManager = $this->buildFakeImageManagerThrownException(
                FakeImageManagerThrownException::REMOVE_THROW_EXCEPTION
            );
            $commandHandler  = $this->buildDeleteBadgeCommandHandler(
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildImageRepository([$this->buildDefaultImage()]),
                $imageManager
            );
            $command = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::USER_ID);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandHandlerException $invalidDeleteBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED,
                $invalidDeleteBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandHandlerWithValidParamsShouldReturnTheBadge()
    {
        $badgeRepository = $this->buildBadgeRepository($this->buildDefaultBadges());
        $imageRepository = $this->buildImageRepository([$this->buildDefaultImage()]);
        $commandHandler  = $this->buildDeleteBadgeCommandHandler(
            $badgeRepository,
            $imageRepository,
            $this->buildImageManager()
        );
        $command         = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::USER_ID);
        $badge           = $badgeRepository->find($command->badgeId());
        $commandHandler->handle($command);
        $this->assertTrue(
            $this->previouslyBadgeHasExisted($badge, $command)
            && $this->currentlyBadgeDoesNotExist($badgeRepository, $command)
            && $this->currentlyImageDoesNotExist($imageRepository, $badge->image()->id())
        );
    }

    /**
     * @param BadgeRepository $badgeRepository
     * @param ImageRepository $imageRepository
     * @param ImageManager $imageManager
     *
     * @return DeleteBadgeCommandHandler
     */
    private function buildDeleteBadgeCommandHandler($badgeRepository, $imageRepository, $imageManager)
    {
        return new DeleteBadgeCommandHandler($badgeRepository, $imageRepository, $imageManager);
    }

    /**
     * @param int $methodException
     * @param Badge[] $badges
     *
     * @return FakeBadgeRepositoryThrownException
     */
    private function buildFakeBadgeRepositoryThrownException($methodException, $badges)
    {
        return new FakeBadgeRepositoryThrownException($methodException, $badges);
    }

    /**
     * @param int $methodException
     * @param Image[] $images
     *
     * @return FakeImageRepositoryThrownException
     */
    private function buildFakeImageRepositoryThrownException($methodException, $images)
    {
        return new FakeImageRepositoryThrownException($methodException, $images);
    }

    /**
     * @param Badge[] $badges
     *
     * @return InMemoryBadgeRepository
     */
    public function buildBadgeRepository($badges)
    {
        return new InMemoryBadgeRepository($badges);
    }

    /**
     * @param Image[] $images
     *
     * @return InMemoryImageRepository
     */
    public function buildImageRepository($images)
    {
        return new InMemoryImageRepository($images);
    }

    /**
     * @return FakeImageManager
     */
    private function buildImageManager()
    {
        return new FakeImageManager();
    }

    /**
     * @param int $methodException
     *
     * @return FakeImageManagerThrownException
     */
    private function buildFakeImageManagerThrownException($methodException)
    {
        return new FakeImageManagerThrownException($methodException);
    }

    /**
     * @return Badge[]
     */
    private function buildDefaultBadges()
    {
        return [FakeBadgeBuilder::build(
            static::BADGE_ID,
            static::BADGE_NAME,
            static::BADGE_DESCRIPTION,
            static::BADGE_IS_MULTI_USER,
            FakeUserBuilder::build(
                static::USER_ID,
                static::USER_EMAIL,
                static::USER_USERNAME,
                static::USER_PASSWORD
            ),
            $this->buildDefaultImage()
        )];
    }

    /**
     * @return Image
     */
    private function buildDefaultImage()
    {
        return FakeImageBuilder::build(
            static::IMAGE_ID,
            static::IMAGE_NAME,
            static::IMAGE_WIDTH,
            static::IMAGE_HEIGHT,
            static::IMAGE_FORMAT
        );
    }

    /**
     * @param string $badgeId
     * @param string $userId
     *
     * @return DeleteBadgeCommand
     */
    private function buildDeleteBadgeCommand($badgeId, $userId)
    {
        return new DeleteBadgeCommand($badgeId, $userId);
    }

    /**
     * @param Badge $badge
     * @param DeleteBadgeCommand $command
     *
     * @return bool
     */
    private function previouslyBadgeHasExisted(Badge $badge, DeleteBadgeCommand $command)
    {
        return $badge->id() === $command->badgeId();
    }

    /**
     * @param BadgeRepository $badgeRepository
     * @param DeleteBadgeCommand $command
     *
     * @return bool
     */
    private function currentlyBadgeDoesNotExist(BadgeRepository $badgeRepository, DeleteBadgeCommand $command)
    {
        return $badgeRepository->find($command->badgeId()) === null;
    }

    /**
     * @param ImageRepository $imageRepository
     * @param string $imageId
     *
     * @return boolean
     */
    private function currentlyImageDoesNotExist(ImageRepository $imageRepository, $imageId)
    {
        return $imageRepository->find($imageId) === null;
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
