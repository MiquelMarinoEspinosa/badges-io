<?php

namespace Test\Interactor\CommandHandler\DeleteBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Infrastructure\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Interactor\CommandHandler\DeleteBadge\DeleteBadgeCommand;
use Interactor\CommandHandler\DeleteBadge\DeleteBadgeCommandHandler;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandHandlerException;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandHandlerExceptionCode;
use Test\Domain\Entity\Badge\FakeBadgeBuilder;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageBuilder;
use Test\Domain\Entity\Tenant\FakeTenantBuilder;

class DeleteBadgeCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_ID              = '1234';
    const BADGE_ID_NOT_EXISTS   = '43321';
    const BADGE_NAME            = 'Badge Name';
    const BADGE_DESCRIPTION     = 'BADGE_DESCRIPTION';
    const BADGE_IS_MULTI_TENANT = false;
    const TENANT_ID             = '4321';
    const TENANT_ID_NOT_EXISTS  = '56789';
    const TENANT_EMAIL          = 'tenantMail@badges.com';
    const TENANT_PASSWORD       = 'B3fr33';
    const IMAGE_ID              = '4567';
    const IMAGE_NAME            = 'Image Name';
    const IMAGE_WIDTH           = 45;
    const IMAGE_HEIGHT          = 45;
    const IMAGE_FORMAT          = 'jpeg';
    const TENANT_USERNAME       = 'tenantName';

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
            $commandHandler = $this->buildDeleteBadgeCommandHandler($badgeRepository);
            $command        = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::TENANT_ID);
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
            $badgeRepository = $this->buildBadgeRepository($this->buildDefaultBadges());
            $commandHandler  = $this->buildDeleteBadgeCommandHandler($badgeRepository);
            $command         = $this->buildDeleteBadgeCommand(static::BADGE_ID_NOT_EXISTS, static::TENANT_ID);
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
    public function badgeFoundButNotValidTenantShouldThrownExceptionTenantNotValidStatusCode()
    {
        try {
            $badgeRepository = $this->buildBadgeRepository($this->buildDefaultBadges());
            $commandHandler  = $this->buildDeleteBadgeCommandHandler($badgeRepository);
            $command         = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::TENANT_ID_NOT_EXISTS);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandHandlerException $invalidDeleteBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN,
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
            $commandHandler = $this->buildDeleteBadgeCommandHandler($badgeRepository);
            $command        = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::TENANT_ID);
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
        $commandHandler = $this->buildDeleteBadgeCommandHandler($badgeRepository);
        $command        = $this->buildDeleteBadgeCommand(static::BADGE_ID, static::TENANT_ID);
        $badge          = $badgeRepository->find($command->badgeId());
        $commandHandler->handle($command);
        $this->assertTrue(
            $this->previouslyBadgeHasExisted($badge, $command)
            && $this->currentlyBadgeDoesNotExist($badgeRepository, $command)
        );
    }

    /**
     * @param BadgeRepository $badgeRepository
     *
     * @return DeleteBadgeCommandHandler
     */
    private function buildDeleteBadgeCommandHandler($badgeRepository)
    {
        return new DeleteBadgeCommandHandler($badgeRepository);
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
     * @return Badge[]
     */
    private function buildDefaultBadges()
    {
        return [FakeBadgeBuilder::build(
            static::BADGE_ID,
            static::BADGE_NAME,
            static::BADGE_DESCRIPTION,
            static::BADGE_IS_MULTI_TENANT,
            FakeTenantBuilder::build(
                static::TENANT_ID,
                static::TENANT_EMAIL,
                static::TENANT_USERNAME,
                static::TENANT_PASSWORD
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
     * @param string $tenantId
     *
     * @return DeleteBadgeCommand
     */
    private function buildDeleteBadgeCommand($badgeId, $tenantId)
    {
        return new DeleteBadgeCommand($badgeId, $tenantId);
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

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
