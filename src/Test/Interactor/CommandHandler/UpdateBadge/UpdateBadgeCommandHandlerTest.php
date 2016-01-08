<?php

namespace Test\Interactor\CommandHandler\CreateBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Domain\Entity\Tenant\Tenant;
use Domain\Entity\Tenant\TenantRepository;
use Domain\Service\IdGenerator;
use Infrastructure\DataTransformer\Domain\Entity\Badge\BadgeNoOpDataTransformer;
use Infrastructure\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Infrastructure\InMemory\Domain\Entity\Image\InMemoryImageRepository;
use Infrastructure\InMemory\Domain\Entity\Tenant\InMemoryTenantRepository;
use Interactor\CommandHandler\UpdateBadge\UpdateBadgeCommand;
use Interactor\CommandHandler\UpdateBadge\UpdateBadgeCommandHandler;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerException;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\UpdateBadge\ImageData\ImageData;
use Interactor\CommandHandler\UpdateBadge\TenantData\TenantData;
use Test\Domain\Entity\Badge\FakeBadgeBuilder;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageBuilder;
use Test\Domain\Entity\Tenant\FakeTenantBuilder;
use Test\Domain\Entity\Tenant\FakeTenantRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageRepositoryThrownException;
use Test\Domain\Service\FakeIdGenerator;

class UpdateBadgeCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_ID                              = '1234';
    const BADGE_NAME                            = 'Badge Name';
    const BADGE_DESCRIPTION                     = 'BADGE_DESCRIPTION';
    const BADGE_IS_MULTI_TENANT                 = false;
    const TENANT_ID                             = '4321';
    const TENANT_ID_NOT_EXISTS                  = '56789';
    const TENANT_ID_NOT_ALLOWED                 = '1256';
    const TENANT_EMAIL                          = 'tenantMail@badges.com';
    const TENANT_PASSWORD                       = 'B3fr33';
    const IMAGE_ID                              = '4567';
    const IMAGE_NAME                            = 'Image Name';
    const IMAGE_WIDTH                           = 45;
    const IMAGE_HEIGHT                          = 45;
    const IMAGE_FORMAT                          = 'jpeg';
    const TENANT_USERNAME                       = 'tenantName';
    const BADGE_ID_VALID_NOT_EXISTS_4321        = '4321';
    const BADGE_NAME_VALID_BADGE_NAME           = 'badgeName';
    const BADGE_DESCRIPTION_VALID_EMPTY         = '';
    const BADGE_IS_MULTI_TENANT_VALID_TRUE      = true;
    const TENANT_EMAIL_VALID_TEST_BADGES_IO_COM = 'test@badges-io.com';
    const TENANT_USERNAME_VALID_BADGES_USER     = 'badgesUser';
    const TENANT_PASSWORD_VALID_BE_FREE         = 'B3FR33';
    const IMAGE_NAME_VALID_FLOWER               = 'flower';
    const IMAGE_WIDTH_VALID_4                   = 4;
    const IMAGE_HEIGHT_VALID_5                  = 5;
    const IMAGE_FORMAT_VALID_JPEG               = 'jpeg';

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
                $this->buildTenantRepository($this->buildDefaultTenants()),
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
                $this->buildTenantRepository($this->buildDefaultTenants()),
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
    public function tenantIdDoesNotMatchTenantBadgeShouldThrownExceptionTenantForbiddenStatusCode()
    {
        try {
            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildTenantRepository($this->buildDefaultTenants()),
                $this->buildImageRepository(),
                $this->buildBadgeRepository($this->buildDefaultBadges()),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand(static::BADGE_ID, static::TENANT_ID_NOT_ALLOWED));

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN,
                $invalidUpdateBadgeCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenFindTenantShouldThrownExceptionBadgeNotUpdatedStatusCode()
    {
        try {
            $tenantRepository = $this->buildFakeTenantRepositoryThrownException(
                $this->buildDefaultTenants(),
                FakeTenantRepositoryThrownException::FIND_THROW_EXCEPTION
            );
            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $tenantRepository,
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
    public function tenantNotExistsShouldThrownExceptionTenantNotFoundStatusCode()
    {
        try {
            $commandHandler = $this->buildUpdateBadgeCommandHandler(
                $this->buildTenantRepository($this->buildDefaultTenants()),
                $this->buildImageRepository(),
                $this->buildBadgeRepository($this->buildDefaultBadges(static::TENANT_ID_NOT_EXISTS)),
                $this->buildBadgeDataTransformer()
            );
            $commandHandler->handle($this->buildCommand(static::BADGE_ID, static::TENANT_ID_NOT_EXISTS));

            $this->thisTestFails();
        } catch (InvalidUpdateBadgeCommandHandlerException $invalidUpdateBadgeCommandHandlerException) {
            $this->assertEquals(
                InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND,
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
                $this->buildTenantRepository($this->buildDefaultTenants()),
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
                $this->buildTenantRepository($this->buildDefaultTenants()),
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
            $this->buildTenantRepository($this->buildDefaultTenants()),
            $imageRepository,
            $badgeRepository,
            $this->buildBadgeDataTransformer()
        );
        $command = $this->buildCommand();

        /** @var Badge $badge */
        $badge = $commandHandler->handle($command);

        $this->assertTrue(
            $this->validateBadgeData($badge, $command)
            && $this->validateTenantData($badge->tenant(), $command->tenantData())
            && $this->validateImageData($badge->image(), $command->imageData())
            && $this->isBadgeStillPersisted($badgeRepository, $badge)
            && $this->isImageStillPersisted($imageRepository, $badge->image())
        );
    }

    /**
     * @param string $badgeId
     * @param string $tenantId
     *
     * @return UpdateBadgeCommand
     */
    private function buildCommand($badgeId = self::BADGE_ID, $tenantId = self::TENANT_ID)
    {
        return $this->buildUpdateBadgeCommand(
            $badgeId,
            static::BADGE_NAME_VALID_BADGE_NAME,
            static::BADGE_DESCRIPTION_VALID_EMPTY,
            static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
            $tenantId,
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
     * @param string $badgeIsMultiTenant
     * @param string $tenantId
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
        $badgeIsMultiTenant,
        $tenantId,
        $imageName,
        $imageWidth,
        $imageHeight,
        $imageFormat
    ) {
        return new UpdateBadgeCommand(
            $badgeId,
            $badgeName,
            $badgeDescription,
            $badgeIsMultiTenant,
            $this->buildTenantData($tenantId),
            $this->buildImageData($imageName, $imageWidth, $imageHeight, $imageFormat)
        );
    }

    /**
     * @param string $id
     *
     * @return TenantData
     */
    private function buildTenantData($id)
    {
        return new TenantData($id);
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
     * @param TenantRepository $tenantRepository
     * @param ImageRepository $imageRepository
     * @param BadgeRepository $badgeRepository
     * @param BadgeDataTransformer $badgeDataTransformer
     *
     * @return UpdateBadgeCommandHandler
     */
    private function buildUpdateBadgeCommandHandler(
        TenantRepository $tenantRepository,
        ImageRepository $imageRepository,
        BadgeRepository $badgeRepository,
        BadgeDataTransformer $badgeDataTransformer
    ) {
        return new UpdateBadgeCommandHandler(
            $tenantRepository,
            $imageRepository,
            $badgeRepository,
            $badgeDataTransformer
        );
    }

    /**
     * @return Tenant[]
     */
    private function buildDefaultTenants()
    {
        return $this->buildTenants(
            static::TENANT_ID,
            static::TENANT_EMAIL_VALID_TEST_BADGES_IO_COM,
            static::TENANT_USERNAME_VALID_BADGES_USER,
            static::TENANT_PASSWORD_VALID_BE_FREE
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
     * @param string $tenantId
     *
     * @return Badge[]
     */
    private function buildDefaultBadges($tenantId = self::TENANT_ID)
    {
        return [FakeBadgeBuilder::build(
            static::BADGE_ID,
            static::BADGE_NAME,
            static::BADGE_DESCRIPTION,
            static::BADGE_IS_MULTI_TENANT,
            FakeTenantBuilder::build(
                $tenantId,
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
        && $badge->isMultiTenant() === $command->isMultiTenant();
    }

    /**
     * @param Tenant $tenant
     * @param TenantData $tenantData
     *
     * @return bool
     */
    private function validateTenantData($tenant, $tenantData)
    {
        return $tenant->id() === $tenantData->id();
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
