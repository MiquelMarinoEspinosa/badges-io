<?php

namespace Test\Interactor\CommandHandler\GetBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Infrastructure\DataTransformer\NoOperation\Domain\Entity\Badge\BadgeNoOpDataTransformer;
use Infrastructure\Persistence\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandHandlerException;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\GetBadge\GetBadgeCommand;
use Interactor\CommandHandler\GetBadge\GetBadgeCommandHandler;
use Test\Domain\Entity\Badge\FakeBadgeBuilder;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageBuilder;
use Test\Domain\Entity\User\FakeUserBuilder;

class GetBadgeCommandHandlerTest extends \PHPUnit_Framework_TestCase
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
            $commandHandler = $this->buildGetBadgeCommandHandler($badgeRepository);
            $command        = $this->buildGetBadgeCommand(static::BADGE_ID, static::USER_ID);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandHandlerException $invalidGetBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND,
                $invalidGetBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function badgeNotFoundWhenFindBadgeShouldThrownExceptionBadgeNotFoundStatusCode()
    {
        try {
            $badgeRepository = $this->buildBadgeRepository($this->buildDefaultBadges());
            $commandHandler  = $this->buildGetBadgeCommandHandler($badgeRepository);
            $command         = $this->buildGetBadgeCommand(static::BADGE_ID_NOT_EXISTS, static::USER_ID);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandHandlerException $invalidGetBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND,
                $invalidGetBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function badgeFoundButNotValidUserShouldThrownExceptionUserNotValidStatusCode()
    {
        try {
            $badgeRepository = $this->buildBadgeRepository($this->buildDefaultBadges());
            $commandHandler  = $this->buildGetBadgeCommandHandler($badgeRepository);
            $command         = $this->buildGetBadgeCommand(static::BADGE_ID, static::USER_ID_NOT_EXISTS);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandHandlerException $invalidGetBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN,
                $invalidGetBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandHandlerWithValidParamsShouldReturnTheBadge()
    {
        $badgeRepository = $this->buildBadgeRepository($this->buildDefaultBadges());
        $commandHandler  = $this->buildGetBadgeCommandHandler($badgeRepository);
        $command         = $this->buildGetBadgeCommand(static::BADGE_ID, static::USER_ID);
        /** @var Badge $badge */
        $badge           = $commandHandler->handle($command);
        $this->assertTrue(
            $badge->id() === $command->badgeId()
            && $badge->user()->id() === $command->userId()
        );
    }

    /**
     * @param BadgeRepository $badgeRepository
     *
     * @return GetBadgeCommandHandler
     */
    private function buildGetBadgeCommandHandler($badgeRepository)
    {
        return new GetBadgeCommandHandler($badgeRepository, $this->buildBadgeDataTransformer());
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
     * @return BadgeNoOpDataTransformer
     */
    private function buildBadgeDataTransformer()
    {
        return new BadgeNoOpDataTransformer();
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
     * @param string $badgeId
     * @param string $userId
     *
     * @return GetBadgeCommand
     */
    private function buildGetBadgeCommand($badgeId, $userId)
    {
        return new GetBadgeCommand($badgeId, $userId);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
