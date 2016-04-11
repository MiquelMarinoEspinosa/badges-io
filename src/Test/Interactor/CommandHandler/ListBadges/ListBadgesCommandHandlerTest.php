<?php

namespace Test\Interactor\CommandHandler\ListBadges;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;
use Infrastructure\DataTransformer\NoOperation\Domain\Entity\Badge\BadgeNoOpCollectionDataTransformer;
use Infrastructure\Persistence\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\User\InMemoryUserRepository;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerExceptionCode;
use Interactor\CommandHandler\ListBadges\ListBadgesCommand;
use Interactor\CommandHandler\ListBadges\ListBadgesCommandHandler;
use Test\Domain\Entity\Badge\FakeBadgeBuilder;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageBuilder;
use Test\Domain\Entity\User\FakeUserBuilder;
use Test\Domain\Entity\User\FakeUserRepositoryThrownException;

class ListBadgesCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_ID                = '1234';
    const BADGE_NAME              = 'Badge Name';
    const BADGE_DESCRIPTION       = 'BADGE_DESCRIPTION';
    const BADGE_IS_MULTI_USER     = true;
    const BADGE_IS_NOT_MULTI_USER = false;
    const USER_ID                 = '4321';
    const USER_ID_NOT_EXISTS      = '56789';
    const USER_EMAIL              = 'userMail@badges.com';
    const USER_USERNAME           = 'userName';
    const USER_PASSWORD           = 'B3fr33';
    const IMAGE_ID                = '4567';
    const IMAGE_NAME              = 'Image Name';
    const IMAGE_WIDTH             = 45;
    const IMAGE_HEIGHT            = 45;
    const IMAGE_FORMAT            = 'jpeg';
    const USER_OTHER_ID           = '1010';
    const USER_OTHER_EMAIL        = 'userOtherMail@badges.com';
    const USER_OTHER_USERNAME     = 'userOtherName';
    const USER_OTHER_PASSWORD     = 'B3C10l';

    /**
     * @test
     */
    public function exceptionRepositoryWhenTryToFindUserShouldThrownBadgesNotFoundStatusCode()
    {
        try {
            $userRepository = $this->buildFakeUserRepositoryThrownException(
                $this->buildDefaultUser(),
                FakeUserRepositoryThrownException::FIND_BY_ID_METHOD_THROW_EXCEPTION
            );
            $commandHandler = $this->buildListBadgesCommandHandler(
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $userRepository
            );
            $command = $this->buildListBadgesCommand();
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandHandlerException $invalidListBadgesCommandHandlerException) {
            $this->assertEquals(
                $invalidListBadgesCommandHandlerException->code(),
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }
    }

    /**
     * @test
     */
    public function userNoExistsShouldThrownUserNotFoundStatusCode()
    {
        try {
            $commandHandler = $this->buildListBadgesCommandHandler(
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildUserRepository($this->buildDefaultUser())
            );
            $command = $this->buildListBadgesCommand(static::USER_ID_NOT_EXISTS);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandHandlerException $invalidListBadgesCommandHandlerException) {
            $this->assertEquals(
                $invalidListBadgesCommandHandlerException->code(),
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenTryToFindBadgesByUserShouldThrownBadgesNotFoundStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                $this->buildDefaultBadges(),
                FakeBadgeRepositoryThrownException::FIND_BY_USER_THROW_EXCEPTION
            );
            $commandHandler = $this->buildListBadgesCommandHandler(
                $badgeRepository,
                $this->buildUserRepository($this->buildDefaultUser())
            );
            $command = $this->buildListBadgesCommand();
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandHandlerException $invalidListBadgesCommandHandlerException) {
            $this->assertEquals(
                $invalidListBadgesCommandHandlerException->code(),
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenTryToFindBadgesMultiUserShouldThrownBadgesNotFoundStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                $this->buildDefaultBadges(),
                FakeBadgeRepositoryThrownException::FIND_BY_MULTI_USER_THROW_EXCEPTION
            );
            $commandHandler = $this->buildListBadgesCommandHandler(
                $badgeRepository,
                $this->buildUserRepository($this->buildDefaultUser())
            );
            $command = $this->buildListBadgesCommand();
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandHandlerException $invalidListBadgesCommandHandlerException) {
            $this->assertEquals(
                $invalidListBadgesCommandHandlerException->code(),
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }
    }

    /**
     * @test
     */
    public function commandHandlerWithValidParametersReturnSomeOrNoneBadges()
    {
        $commandHandler = $this->buildListBadgesCommandHandler(
            $this->buildBadgeRepository($this->buildDefaultBadges()),
            $this->buildUserRepository($this->buildDefaultUser())
        );
        $command = $this->buildListBadgesCommand();
        $badges = $commandHandler->handle($command);

        $this->assertTrue($this->validateBadges($badges, $command->userId()));
    }

    /**
     * @param string $userId
     *
     * @return ListBadgesCommand
     */
    private function buildListBadgesCommand($userId = self::USER_ID)
    {
        return new ListBadgesCommand($userId);
    }

    /**
     * @param BadgeRepository $badgeRepository
     * @param UserRepository $userRepository
     *
     * @return ListBadgesCommandHandler
     */
    private function buildListBadgesCommandHandler(
        BadgeRepository $badgeRepository,
        UserRepository $userRepository
    ) {
        return new ListBadgesCommandHandler(
            $badgeRepository,
            $userRepository,
            $this->buildBadgeCollectionDataTransformer()
        );
    }

    /**
     * @return BadgeNoOpCollectionDataTransformer
     */
    private function buildBadgeCollectionDataTransformer()
    {
        return new BadgeNoOpCollectionDataTransformer();
    }

    /**
     * @param Badge[] $badges
     * @param int $methodException
     *
     * @return FakeBadgeRepositoryThrownException
     */
    private function buildFakeBadgeRepositoryThrownException($badges, $methodException)
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
     * @return Badge[]
     */
    private function buildDefaultBadges()
    {
        return [$this->buildDefaultBadge(), $this->buildOtherDefaultBadge()];
    }

    /**
     * @return FakeBadgeBuilder
     */
    private function buildDefaultBadge()
    {
        return FakeBadgeBuilder::build(
            static::BADGE_ID,
            static::BADGE_NAME,
            static::BADGE_DESCRIPTION,
            static::BADGE_IS_NOT_MULTI_USER,
            FakeUserBuilder::build(
                static::USER_ID,
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
        );
    }

    /**
     * @return FakeBadgeBuilder
     */
    private function buildOtherDefaultBadge()
    {
        return FakeBadgeBuilder::build(
            static::BADGE_ID,
            static::BADGE_NAME,
            static::BADGE_DESCRIPTION,
            static::BADGE_IS_MULTI_USER,
            FakeUserBuilder::build(
                static::USER_OTHER_ID,
                static::USER_OTHER_EMAIL,
                static::USER_OTHER_USERNAME,
                static::USER_OTHER_PASSWORD
            ),
            FakeImageBuilder::build(
                static::IMAGE_ID,
                static::IMAGE_NAME,
                static::IMAGE_WIDTH,
                static::IMAGE_HEIGHT,
                static::IMAGE_FORMAT
            )
        );
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
     * @return User[]
     */
    private function buildDefaultUser()
    {
        return $this->buildUsers(
            static::USER_ID,
            static::USER_EMAIL,
            static::USER_USERNAME,
            static::USER_PASSWORD
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

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }

    /**
     * @param Badge[] $badges
     * @param string $userId
     *
     * @return bool
     */
    private function validateBadges($badges, $userId)
    {
        $allBadgesNotValid = false;
        $allBadgesValid    = true;
        foreach ($badges as $badge) {
            if ($this->isNotMultiUser($badge) && $this->userIsNotTheOwner($badge, $userId)) {
                return $allBadgesNotValid;
            }
        }

        return $allBadgesValid;
    }

    /**
     * @param Badge $badge
     *
     * @return bool
     */
    private function isNotMultiUser(Badge $badge)
    {
        return !$badge->isMultiUser();
    }

    /**
     * @param Badge $badge
     * @param string $userId
     *
     * @return bool
     */
    private function userIsNotTheOwner(Badge $badge, $userId)
    {
        return $badge->user()->id() !== $userId;
    }
}
