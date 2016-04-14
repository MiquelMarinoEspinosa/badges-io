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
use Infrastructure\DataTransformer\NoOperation\Domain\Entity\Badge\BadgeNoOpDataTransformer;
use Infrastructure\Persistence\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\Image\InMemoryImageRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\User\InMemoryUserRepository;
use Interactor\CommandHandler\UpdateBadge\UpdateBadgeCommand;
use Interactor\CommandHandler\UpdateBadge\UpdateBadgeCommandHandler;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerException;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\UpdateBadge\ImageData\ImageData;
use Interactor\CommandHandler\UpdateBadge\UserData\UserData;
use Test\Domain\Entity\Badge\FakeBadgeBuilder;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageBuilder;
use Test\Domain\Entity\User\FakeUserBuilder;
use Test\Domain\Entity\User\FakeUserRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageRepositoryThrownException;
use Test\Domain\Service\FakeIdGenerator;

class UpdateBadgeCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_ID                            = '1234';
    const BADGE_NAME                          = 'Badge Name';
    const BADGE_DESCRIPTION                   = 'BADGE_DESCRIPTION';
    const BADGE_IS_MULTI_USER                 = false;
    const USER_ID                             = '4321';
    const USER_ID_NOT_EXISTS                  = '56789';
    const USER_ID_NOT_ALLOWED                 = '1256';
    const USER_EMAIL                          = 'userMail@badges.com';
    const USER_PASSWORD                       = 'B3fr33';
    const IMAGE_ID                            = '4567';
    const IMAGE_NAME                          = 'Image Name';
    const IMAGE_WIDTH                         = 45;
    const IMAGE_HEIGHT                        = 45;
    const IMAGE_FORMAT                        = 'jpeg';
    const USER_USERNAME                       = 'userName';
    const BADGE_ID_VALID_NOT_EXISTS_4321      = '4321';
    const BADGE_NAME_VALID_BADGE_NAME         = 'badgeName';
    const BADGE_DESCRIPTION_VALID_EMPTY       = '';
    const BADGE_IS_MULTI_USER_VALID_TRUE      = true;
    const USER_EMAIL_VALID_TEST_BADGES_IO_COM = 'test@badges-io.com';
    const USER_USERNAME_VALID_BADGES_USER     = 'badgesUser';
    const USER_PASSWORD_VALID_BE_FREE         = 'B3FR33';
    const IMAGE_NAME_VALID_FLOWER             = 'flower';
    const IMAGE_WIDTH_VALID_4                 = 4;
    const IMAGE_HEIGHT_VALID_5                = 5;
    const IMAGE_FORMAT_VALID_JPEG             = 'jpeg';

    /**
     * @test
     */
    public function exceptionRepositoryWhenRemoveBadgeShouldThrownExceptionBadgeNotUpdatedStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                FakeBadgeRepositoryThrownException::REMOVE_THROW_EXCEPTION,
                $this->buildDefaultBadges()
            );

            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $badgeRepository,
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand(static::BADGE_ID));

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenRemoveImageShouldThrownExceptionBadgeNotUpdatedStatusCode()
    {
        try {
            $imageRepository = $this->buildFakeImageRepositoryThrownException(
                FakeBadgeRepositoryThrownException::REMOVE_THROW_EXCEPTION,
                [
                    FakeImageBuilder::build(
                        static::IMAGE_ID,
                        static::IMAGE_NAME,
                        static::IMAGE_WIDTH,
                        static::IMAGE_HEIGHT,
                        static::IMAGE_FORMAT
                    )
                ]
            );

            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $imageRepository,
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand(static::BADGE_ID));

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenFindBadgeShouldThrownExceptionBadgeNotUpdatedStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                FakeBadgeRepositoryThrownException::FIND_THROW_EXCEPTION,
                $this->buildDefaultBadges()
            );

            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $badgeRepository,
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand(static::BADGE_ID));

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function badgeNotExistsShouldThrownExceptionBadgeNotFoundStatusCode()
    {
        try {
            $badgeRepository = $this->buildBadgeRepository($this->buildDefaultBadges());

            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $badgeRepository,
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand(static::BADGE_ID_VALID_NOT_EXISTS_4321));

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function userIdDoesNotMatchUserBadgeShouldThrownExceptionUserForbiddenStatusCode()
    {
        try {
            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand(static::BADGE_ID, static::USER_ID_NOT_ALLOWED));

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenFindUserShouldThrownExceptionBadgeNotUpdatedStatusCode()
    {
        try {
            $userRepository = $this->buildFakeUserRepositoryThrownException(
                $this->buildDefaultUsers(),
                FakeUserRepositoryThrownException::FIND_BY_ID_METHOD_THROW_EXCEPTION
            );
            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $userRepository,
                $this->buildImageRepository(),
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand());

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function userNotExistsShouldThrownExceptionUserNotFoundStatusCode()
    {
        try {
            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $this->buildBadgeRepository($this->buildDefaultBadges(static::USER_ID_NOT_EXISTS)),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand(static::BADGE_ID, static::USER_ID_NOT_EXISTS));

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenPersistImageShouldThrownExceptionBadgeNotUpdatedStatusCode()
    {
        try {
            $imageRepository = $this->buildFakeImageRepositoryThrownException(
                FakeImageRepositoryThrownException::PERSIST_THROW_EXCEPTION
            );
            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $imageRepository,
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand());

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenPersistBadgeShouldThrownExceptionBadgeNotUpdatedStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                FakeBadgeRepositoryThrownException::PERSIST_THROW_EXCEPTION,
                $this->buildDefaultBadges()
            );
            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildUserRepository($this->buildDefaultUsers()),
                $this->buildImageRepository(),
                $badgeRepository,
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand());

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function updatedBadgeShouldReturnTheBadgeDataAndUpdatedTheImageAndTheBadgeInRepositories()
    {
        $imageRepository = $this->buildImageRepository();
        $badgeRepository = $this->buildBadgeRepository($this->buildDefaultBadges());

        $commandHandler = $this->buildUpdateBadgeCommandHandler(
            $this->buildUserRepository($this->buildDefaultUsers()),
            $imageRepository,
            $badgeRepository,
            $this->buildBadgeDataTransformer()
        );
        $command = $this->buildCommand();

        /** @var Badge $badge */
        $badge = $commandHandler->handle($command);

        $this->assertTrue(
            $this->validateBadgeData($badge, $command)
            && $this->validateUserData($badge->user(), $command->userData())
            && $this->validateImageData($badge->image(), $command->imageData())
            && $this->isBadgeStillPersisted($badgeRepository, $badge)
        );
    }

    /**
     * @param string $badgeId
     * @param string $userId
     *
     * @return UpdateBadgeCommand
     */
    private function buildCommand($badgeId = self::BADGE_ID, $userId = self::USER_ID)
    {
        return $this->buildUpdateBadgeCommand(
            $badgeId,
            static::BADGE_NAME_VALID_BADGE_NAME,
            static::BADGE_DESCRIPTION_VALID_EMPTY,
            static::BADGE_IS_MULTI_USER_VALID_TRUE,
            $userId,
            static::IMAGE_NAME_VALID_FLOWER,
            static::IMAGE_WIDTH_VALID_4,
            static::IMAGE_HEIGHT_VALID_5,
            static::IMAGE_FORMAT_VALID_JPEG
        );
    }

    /**
     * @param string $badgeId
     * @param string $badgeName
     * @param string $badgeDescription
     * @param string $badgeIsMultiUser
     * @param string $userId
     * @param string $imageName
     * @param int $imageWidth
     * @param int $imageHeight
     * @param string $imageFormat
     *
     * @return UpdateBadgeCommand
     */
    private function buildUpdateBadgeCommand(
        $badgeId,
        $badgeName,
        $badgeDescription,
        $badgeIsMultiUser,
        $userId,
        $imageName,
        $imageWidth,
        $imageHeight,
        $imageFormat
    ) {
        return new UpdateBadgeCommand(
            $badgeId,
            $badgeName,
            $badgeDescription,
            $badgeIsMultiUser,
            $this->buildUserData($userId),
            $this->buildImageData($imageName, $imageWidth, $imageHeight, $imageFormat)
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
     * @param int $imageFormat
     *
     * @return ImageData
     */
    private function buildImageData($name, $width, $height, $imageFormat)
    {
        return new ImageData($name, $width, $height, $imageFormat);
    }

    /**
     * @param UserRepository $userRepository
     * @param ImageRepository $imageRepository
     * @param BadgeRepository $badgeRepository
     * @param BadgeDataTransformer $badgeDataTransformer
     *
     * @return UpdateBadgeCommandHandler
     */
    private function buildUpdateBadgeCommandHandler(
        UserRepository $userRepository,
        ImageRepository $imageRepository,
        BadgeRepository $badgeRepository,
        BadgeDataTransformer $badgeDataTransformer
    ) {
        return new UpdateBadgeCommandHandler(
            $userRepository,
            $imageRepository,
            $badgeRepository,
            $badgeDataTransformer,
            $this->buildIdGenerator()
        );
    }

    /**
     * @return User[]
     */
    private function buildDefaultUsers()
    {
        return $this->buildUsers(
            static::USER_ID,
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
     * @param Badge[] $badges
     *
     * @return InMemoryBadgeRepository
     */
    public function buildBadgeRepository($badges)
    {
        return new InMemoryBadgeRepository($badges);
    }

    /**
     * @param string $userId
     *
     * @return Badge[]
     */
    private function buildDefaultBadges($userId = self::USER_ID)
    {
        return [FakeBadgeBuilder::build(
            static::BADGE_ID,
            static::BADGE_NAME,
            static::BADGE_DESCRIPTION,
            static::BADGE_IS_MULTI_USER,
            FakeUserBuilder::build(
                $userId,
                static::USER_EMAIL,
                static::USER_USERNAME,
                static::USER_PASSWORD
            ),
            FakeImageBuilder::build(
                static::IMAGE_ID,
                static::IMAGE_NAME,
                static::IMAGE_WIDTH,
                static::IMAGE_HEIGHT,
                static::IMAGE_FORMAT
            )
        )];
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
        return new InMemoryImageRepository(
            [
                FakeImageBuilder::build(
                    static::IMAGE_ID,
                    static::IMAGE_NAME,
                    static::IMAGE_WIDTH,
                    static::IMAGE_HEIGHT,
                    static::IMAGE_FORMAT
                )
            ]
        );
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
     * @return BadgeNoOpDataTransformer
     */
    private function buildBadgeDataTransformer()
    {
        return new BadgeNoOpDataTransformer();
    }

    /**
     * @param Badge $badge
     * @param UpdateBadgeCommand $command
     * @return bool
     */
    private function validateBadgeData($badge, $command)
    {
        return $badge->id() === $command->id()
        && $badge->name() === $command->name()
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
    private function isBadgeStillPersisted($badgeRepository, $badge)
    {
        return $badgeRepository->find($badge->id()) instanceof Badge;
    }

    /**
     * @param ImageRepository $imageRepository
     * @param Image $image
     *
     * @return bool
     */
    private function isImageStillPersisted($imageRepository, $image)
    {
        return $imageRepository->find($image->id()) instanceof Image;
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
