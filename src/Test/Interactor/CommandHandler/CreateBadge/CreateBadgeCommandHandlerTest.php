<?php

namespace Test\Interactor\CommandHandler\CreateBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;
use Domain\Service\IdGenerator;
use Domain\Service\ImageManager;
use Infrastructure\DataTransformer\NoOperation\Domain\Entity\Badge\BadgeNoOpDataTransformer;
use Infrastructure\Persistence\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\Image\InMemoryImageRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\User\InMemoryUserRepository;
use Interactor\CommandHandler\CreateBadge\CreateBadgeCommand;
use Interactor\CommandHandler\CreateBadge\CreateBadgeCommandHandler;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\CommandHandler\CreateBadge\UserData\UserData;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\User\FakeUserBuilder;
use Test\Domain\Entity\User\FakeUserRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageRepositoryThrownException;
use Test\Domain\Service\FakeIdGenerator;
use Test\Domain\Service\FakeImageManager;
use Test\Domain\Service\FakeImageManagerThrownException;

class CreateBadgeCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_NAME_VALID_BADGE_NAME         = 'badgeName';
    const BADGE_DESCRIPTION_VALID_EMPTY       = '';
    const BADGE_IS_MULTI_USER_VALID_TRUE      = true;
    const USER_ID_VALID_1234                  = '1234';
    const USER_EMAIL_VALID_TEST_BADGES_IO_COM = 'test@badges-io.com';
    const USER_USERNAME_VALID_BADGES_USER     = 'badgesUser';
    const USER_PASSWORD_VALID_BE_FREE         = 'B3FR33';
    const IMAGE_NAME_VALID_FLOWER             = 'flower';
    const IMAGE_WIDTH_VALID_4                 = 4;
    const IMAGE_HEIGHT_VALID_5                = 5;
    const IMAGE_FORMAT_VALID_JPEG             = 'jpeg';
    const USER_ID_NOT_EXISTS_12345            = '12345';
    const IMAGE_PATH_VALID_TMP_X452           = '/tmp/x452';

    /**
     * @test
     */
    public function exceptionRepositoryWhenFindUserShouldThrownExceptionBadgeNotCreatedStatusCode()
    {
        try {
            $userRepository = $this->buildFakeUserRepositoryThrownException(
                $this->buildDefaultUsers(),
                FakeUserRepositoryThrownException::FIND_BY_ID_METHOD_THROW_EXCEPTION
            );
            $commandHandler = $this->buildCreateBadgeCommandHandler(
                $userRepository,
                $this->buildImageRepository(),
                $this->buildBadgeRepository(),
                $this->buildIdGenerator(),
                $this->buildImageManager(),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand());

            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandHandlerException $invalidCreateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED,
                $invalidCreateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notExistsSomeUserIdShouldThrownExceptionUserNotFoundStatusCode()
    {
        try {
            $command = $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_NOT_EXISTS_12345,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_VALID_5,
                static::IMAGE_FORMAT_VALID_JPEG,
                static::IMAGE_PATH_VALID_TMP_X452
            );

            $commandHandler = $this->buildCreateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $this->buildBadgeRepository(),
                $this->buildIdGenerator(),
                $this->buildImageManager(),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($command);

            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandHandlerException $invalidCreateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND,
                $invalidCreateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenPersistImageShouldThrownExceptionBadgeNotCreatedStatusCode()
    {
        try {
            $imageRepository = $this->buildFakeImageRepositoryThrownException(
                FakeImageRepositoryThrownException::PERSIST_THROW_EXCEPTION
            );
            $commandHandler = $this->buildCreateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $imageRepository,
                $this->buildBadgeRepository(),
                $this->buildIdGenerator(),
                $this->buildImageManager(),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand());

            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandHandlerException $invalidCreateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED,
                $invalidCreateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenPersistBadgeShouldThrownExceptionBadgeNotCreatedStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                FakeBadgeRepositoryThrownException::PERSIST_THROW_EXCEPTION
            );

            $commandHandler = $this->buildCreateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $badgeRepository,
                $this->buildIdGenerator(),
                $this->buildImageManager(),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand());

            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandHandlerException $invalidCreateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED,
                $invalidCreateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionImageManagerWhenUploadShouldThrownExceptionBadgeNotCreatedStatusCode()
    {
        try {
            $imageManager = $this->buildFakeImageManagerThrownException(
                FakeImageManagerThrownException::UPLOAD_THROW_EXCEPTION
            );

            $commandHandler = $this->buildCreateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $this->buildBadgeRepository(),
                $this->buildIdGenerator(),
                $imageManager,
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand());

            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandHandlerException $invalidCreateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED,
                $invalidCreateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function persistBadgeShouldReturnTheBadgeDataAndPersistTheImageAndTheBadgeInRepositories()
    {
        $imageRepository = $this->buildImageRepository();
        $badgeRepository = $this->buildBadgeRepository();

        $commandHandler = $this->buildCreateBadgeCommandHandler(
            $this->buildUserRepository($this->buildDefaultUsers()),
            $imageRepository,
            $badgeRepository,
            $this->buildIdGenerator(),
            $this->buildImageManager(),
            $this->buildBadgeDataTransformer()
        );
        $command = $this->buildCommand();

        /** @var Badge $badge */
        $badge = $commandHandler->handle($command);

        $this->assertTrue(
            $this->validateBadgeData($badge, $command)
            && $this->validateUserData($badge->user(), $command->UserData())
            && $this->validateImageData($badge->image(), $command->imageData())
            && $this->isBadgePersisted($badgeRepository, $badge)
            && $this->isImagePersisted($imageRepository, $badge->image())
        );
    }

    /**
     * @return CreateBadgeCommand
     */
    private function buildCommand()
    {
        return $this->buildCreateBadgeCommand(
            static::BADGE_NAME_VALID_BADGE_NAME,
            static::BADGE_DESCRIPTION_VALID_EMPTY,
            static::BADGE_IS_MULTI_USER_VALID_TRUE,
            static::USER_ID_VALID_1234,
            static::IMAGE_NAME_VALID_FLOWER,
            static::IMAGE_WIDTH_VALID_4,
            static::IMAGE_HEIGHT_VALID_5,
            static::IMAGE_FORMAT_VALID_JPEG,
            static::IMAGE_PATH_VALID_TMP_X452
        );
    }

    /**
     * @param string $badgeName
     * @param string $badgeDescription
     * @param boolean $badgeIsMultiUser
     * @param string $userId
     * @param string $imageName
     * @param int $imageWidth
     * @param int $imageHeight
     * @param string $imageFormat
     * @param string $imagePath
     *
     * @return CreateBadgeCommand
     */
    private function buildCreateBadgeCommand(
        $badgeName,
        $badgeDescription,
        $badgeIsMultiUser,
        $userId,
        $imageName,
        $imageWidth,
        $imageHeight,
        $imageFormat,
        $imagePath
    ) {
        return new CreateBadgeCommand(
            $badgeName,
            $badgeDescription,
            $badgeIsMultiUser,
            $this->buildUserData($userId),
            $this->buildImageData($imageName, $imageWidth, $imageHeight, $imageFormat, $imagePath)
        );
    }

    /**
     * @param string $id
     *
     * @return UserData
     */
    private function buildUserData($id)
    {
        return new UserData($id);
    }

    /**
     * @param string $name
     * @param int $width
     * @param int $height
     * @param int $format
     * @param string $path
     *
     * @return ImageData
     */
    private function buildImageData($name, $width, $height, $format, $path)
    {
        return new ImageData($name, $width, $height, $format, $path);
    }

    private function buildCreateBadgeCommandHandler(
        UserRepository       $userRepository,
        ImageRepository      $imageRepository,
        BadgeRepository      $badgeRepository,
        IdGenerator          $idGenerator,
        ImageManager         $imageManager,
        BadgeDataTransformer $badgeDataTransformer
    ) {
        return new CreateBadgeCommandHandler(
            $userRepository,
            $imageRepository,
            $badgeRepository,
            $idGenerator,
            $imageManager,
            $badgeDataTransformer
        );
    }

    /**
     * @return User[]
     */
    private function buildDefaultUsers()
    {
        return $this->buildUsers(
            static::USER_ID_VALID_1234,
            static::USER_EMAIL_VALID_TEST_BADGES_IO_COM,
            static::USER_USERNAME_VALID_BADGES_USER,
            static::USER_PASSWORD_VALID_BE_FREE
        );
    }

    /**
     * @param string $id
     * @param string $email
     * @param string $username
     * @param string $passWord
     *
     * @return User[]
     */
    private function buildUsers($id, $email, $username, $passWord)
    {
        return [$this->buildUser($id, $email, $username, $passWord)];
    }

    /**
     * @param string $id
     * @param string $email
     * @param string $username
     * @param string $passWord
     *
     * @return User
     */
    private function buildUser($id, $email, $username, $passWord)
    {
        return FakeUserBuilder::build($id, $email, $username, $passWord);
    }

    /**
     * @param User[] $users
     * @param int $methodException
     *
     * @return FakeUserRepositoryThrownException
     */
    private function buildFakeUserRepositoryThrownException($users, $methodException)
    {
        return new FakeUserRepositoryThrownException($users, $methodException);
    }

    /**
     * @param User[] $users
     *
     * @return InMemoryUserRepository
     */
    private function buildUserRepository($users)
    {
        return new InMemoryUserRepository($users);
    }

    /**
     * @return InMemoryImageRepository
     */
    private function buildImageRepository()
    {
        return new InMemoryImageRepository();
    }

    /**
     * @param int $methodException
     *
     * @return FakeImageRepositoryThrownException
     */
    private function buildFakeImageRepositoryThrownException($methodException)
    {
        return new FakeImageRepositoryThrownException($methodException);
    }

    /**
     * @return IdGenerator
     */
    private function buildIdGenerator()
    {
        return new FakeIdGenerator();
    }

    /**
     * @return InMemoryBadgeRepository
     */
    private function buildBadgeRepository()
    {
        return new InMemoryBadgeRepository();
    }

    /**
     * @param int $methodException
     *
     * @return FakeBadgeRepositoryThrownException
     */
    private function buildFakeBadgeRepositoryThrownException($methodException)
    {
        return new FakeBadgeRepositoryThrownException($methodException);
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
     * @return BadgeNoOpDataTransformer
     */
    private function buildBadgeDataTransformer()
    {
        return new BadgeNoOpDataTransformer();
    }

    /**
     * @param Badge $badge
     * @param CreateBadgeCommand $command
     * @return bool
     */
    private function validateBadgeData($badge, $command)
    {
        return $badge->name() === $command->name()
        && $badge->description() === $command->description()
        && $badge->isMultiUser() === $command->isMultiUser();
    }

    /**
     * @param User $user
     * @param UserData $userData
     *
     * @return bool
     */
    private function validateUserData($user, $userData)
    {
        return $user->id() === $userData->id();
    }

    /**
     * @param Image $image
     * @param ImageData $imageData
     *
     * @return bool
     */
    private function validateImageData($image, $imageData)
    {
        return $image->name() === $imageData->name()
        && $image->format() === $imageData->format()
        && $image->width() === $imageData->width()
        && $image->height() === $imageData->height();
    }

    /**
     * @param BadgeRepository $badgeRepository
     * @param Badge $badge
     *
     * @return bool
     */
    private function isBadgePersisted($badgeRepository, $badge)
    {
        return $badgeRepository->find($badge->id()) instanceof Badge;
    }

    /**
     * @param ImageRepository $imageRepository
     * @param Image $image
     *
     * @return bool
     */
    private function isImagePersisted($imageRepository, $image)
    {
        return $imageRepository->find($image->id()) instanceof Image;
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
