<?php

namespace Test\Interactor\CommandHandler\ListBadges;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Tenant\Tenant;
use Domain\Entity\Tenant\TenantRepository;
use Infrastructure\DataTransformer\NoOperation\Domain\Entity\Badge\BadgeNoOpCollectionDataTransformer;
use Infrastructure\Persistence\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\Tenant\InMemoryTenantRepository;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerExceptionCode;
use Interactor\CommandHandler\ListBadges\ListBadgesCommand;
use Interactor\CommandHandler\ListBadges\ListBadgesCommandHandler;
use Test\Domain\Entity\Badge\FakeBadgeBuilder;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageBuilder;
use Test\Domain\Entity\Tenant\FakeTenantBuilder;
use Test\Domain\Entity\Tenant\FakeTenantRepositoryThrownException;

class ListBadgesCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_ID                  = '1234';
    const BADGE_NAME                = 'Badge Name';
    const BADGE_DESCRIPTION         = 'BADGE_DESCRIPTION';
    const BADGE_IS_MULTI_TENANT     = true;
    const BADGE_IS_NOT_MULTI_TENANT = false;
    const TENANT_ID                 = '4321';
    const TENANT_ID_NOT_EXISTS      = '56789';
    const TENANT_EMAIL              = 'tenantMail@badges.com';
    const TENANT_USERNAME           = 'tenantName';
    const TENANT_PASSWORD           = 'B3fr33';
    const IMAGE_ID                  = '4567';
    const IMAGE_NAME                = 'Image Name';
    const IMAGE_WIDTH               = 45;
    const IMAGE_HEIGHT              = 45;
    const IMAGE_FORMAT              = 'jpeg';
    const TENANT_OTHER_ID           = '1010';
    const TENANT_OTHER_EMAIL        = 'tenantOtherMail@badges.com';
    const TENANT_OTHER_USERNAME     = 'tenantOtherName';
    const TENANT_OTHER_PASSWORD     = 'B3C10l';

    /**
     * @test
     */
    public function exceptionRepositoryWhenTryToFindTenantShouldThrownBadgesNotFoundStatusCode()
    {
        try {
            $tenantRepository = $this->buildFakeTenantRepositoryThrownException(
                $this->buildDefaultTenants(),
                FakeTenantRepositoryThrownException::FIND_THROW_EXCEPTION
            );
            $commandHandler = $this->buildListBadgesCommandHandler(
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $tenantRepository
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
    public function tenantNoExistsShouldThrownTenantNotFoundStatusCode()
    {
        try {
            $commandHandler = $this->buildListBadgesCommandHandler(
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildTenantRepository($this->buildDefaultTenants())
            );
            $command = $this->buildListBadgesCommand(static::TENANT_ID_NOT_EXISTS);
            $commandHandler->handle($command);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandHandlerException $invalidListBadgesCommandHandlerException) {
            $this->assertEquals(
                $invalidListBadgesCommandHandlerException->code(),
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenTryToFindBadgesByTenantShouldThrownBadgesNotFoundStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                $this->buildDefaultBadges(),
                FakeBadgeRepositoryThrownException::FIND_BY_TENANT_THROW_EXCEPTION
            );
            $commandHandler = $this->buildListBadgesCommandHandler(
                $badgeRepository,
                $this->buildTenantRepository($this->buildDefaultTenants())
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
    public function exceptionRepositoryWhenTryToFindBadgesMultiTenantShouldThrownBadgesNotFoundStatusCode()
    {
        try {
            $badgeRepository = $this->buildFakeBadgeRepositoryThrownException(
                $this->buildDefaultBadges(),
                FakeBadgeRepositoryThrownException::FIND_BY_MULTI_TENANT_THROW_EXCEPTION
            );
            $commandHandler = $this->buildListBadgesCommandHandler(
                $badgeRepository,
                $this->buildTenantRepository($this->buildDefaultTenants())
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
            $this->buildTenantRepository($this->buildDefaultTenants())
        );
        $command = $this->buildListBadgesCommand();
        $badges = $commandHandler->handle($command);

        $this->assertTrue($this->validateBadges($badges, $command->tenantId()));
    }

    /**
     * @param string $tenantId
     *
     * @return ListBadgesCommand
     */
    private function buildListBadgesCommand($tenantId = self::TENANT_ID)
    {
        return new ListBadgesCommand($tenantId);
    }

    /**
     * @param BadgeRepository $badgeRepository
     * @param TenantRepository $tenantRepository
     *
     * @return ListBadgesCommandHandler
     */
    private function buildListBadgesCommandHandler(
        BadgeRepository $badgeRepository,
        TenantRepository $tenantRepository
    ) {
        return new ListBadgesCommandHandler(
            $badgeRepository,
            $tenantRepository,
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
            static::BADGE_IS_NOT_MULTI_TENANT,
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
            static::BADGE_IS_MULTI_TENANT,
            FakeTenantBuilder::build(
                static::TENANT_OTHER_ID,
                static::TENANT_OTHER_EMAIL,
                static::TENANT_OTHER_USERNAME,
                static::TENANT_OTHER_PASSWORD
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
     * @param Tenant[] $tenants
     * @param int $methodException
     *
     * @return FakeTenantRepositoryThrownException
     */
    private function buildFakeTenantRepositoryThrownException($tenants, $methodException)
    {
        return new FakeTenantRepositoryThrownException($tenants, $methodException);
    }

    /**
     * @param Tenant[] $tenants
     *
     * @return InMemoryTenantRepository
     */
    private function buildTenantRepository($tenants)
    {
        return new InMemoryTenantRepository($tenants);
    }

    /**
     * @return Tenant[]
     */
    private function buildDefaultTenants()
    {
        return $this->buildTenants(
            static::TENANT_ID,
            static::TENANT_EMAIL,
            static::TENANT_USERNAME,
            static::TENANT_PASSWORD
        );
    }

    /**
     * @param string $id
     * @param string $email
     * @param string $username
     * @param string $passWord
     *
     * @return Tenant[]
     */
    private function buildTenants($id, $email, $username, $passWord)
    {
        return [$this->buildTenant($id, $email, $username, $passWord)];
    }

    /**
     * @param string $id
     * @param string $email
     * @param string $username
     * @param string $passWord
     *
     * @return Tenant
     */
    private function buildTenant($id, $email, $username, $passWord)
    {
        return FakeTenantBuilder::build($id, $email, $username, $passWord);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }

    /**
     * @param Badge[] $badges
     * @param string $tenantId
     *
     * @return bool
     */
    private function validateBadges($badges, $tenantId)
    {
        $allBadgesNotValid = false;
        $allBadgesValid    = true;
        foreach ($badges as $badge) {
            if ($this->isNotMultiTenant($badge) && $this->tenantIsNotTheOwner($badge, $tenantId)) {
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
    private function isNotMultiTenant(Badge $badge)
    {
        return !$badge->isMultiTenant();
    }

    /**
     * @param Badge $badge
     * @param string $tenantId
     *
     * @return bool
     */
    private function tenantIsNotTheOwner(Badge $badge, $tenantId)
    {
        return $badge->tenant()->id() !== $tenantId;
    }
}
