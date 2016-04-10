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
use Infrastructure\DataTransformer\NoOperation\Domain\Entity\Badge\BadgeNoOpDataTransformer;
use Infrastructure\Persistence\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\Image\InMemoryImageRepository;
use Infrastructure\Persistence\InMemory\Domain\Entity\Tenant\InMemoryTenantRepository;
use Interactor\CommandHandler\CreateBadge\CreateBadgeCommand;
use Interactor\CommandHandler\CreateBadge\CreateBadgeCommandHandler;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\CommandHandler\CreateBadge\TenantData\TenantData;
use Test\Domain\Entity\Badge\FakeBadgeRepositoryThrownException;
use Test\Domain\Entity\Tenant\FakeTenantBuilder;
use Test\Domain\Entity\Tenant\FakeTenantRepositoryThrownException;
use Test\Domain\Entity\Image\FakeImageRepositoryThrownException;
use Test\Domain\Service\FakeIdGenerator;

class CreateBadgeCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_NAME_VALID_BADGE_NAME           = 'badgeName';
    const BADGE_DESCRIPTION_VALID_EMPTY         = '';
    const BADGE_IS_MULTI_TENANT_VALID_TRUE      = true;
    const TENANT_ID_VALID_1234                  = '1234';
    const TENANT_EMAIL_VALID_TEST_BADGES_IO_COM = 'test@badges-io.com';
    const TENANT_USERNAME_VALID_BADGES_USER     = 'badgesUser';
    const TENANT_PASSWORD_VALID_BE_FREE         = 'B3FR33';
    const IMAGE_NAME_VALID_FLOWER               = 'flower';
    const IMAGE_WIDTH_VALID_4                   = 4;
    const IMAGE_HEIGHT_VALID_5                  = 5;
    const IMAGE_FORMAT_VALID_JPEG               = 'jpeg';
    const TENANT_ID_NOT_EXISTS_12345            = '12345';

    /**
     * @test
     */
    public function exceptionRepositoryWhenFindTenantShouldThrownExceptionBadgeNotCreatedStatusCode()
    {
        try {
            $tenantRepository = $this->buildFakeTenantRepositoryThrownException(
                $this->buildDefaultTenants(),
                FakeTenantRepositoryThrownException::FIND_THROW_EXCEPTION
            );
            $commandHandler  = $this->buildCreateBadgeCommandHandler(
                $tenantRepository,
                $this->buildImageRepository(),
                $this->buildBadgeRepository(),
                $this->buildIdGenerator(),
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
    public function notExistsSomeTenantIdShouldThrownExceptionTenantNotFoundStatusCode()
    {
        try {
            $command = $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_NOT_EXISTS_12345,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_VALID_5,
                static::IMAGE_FORMAT_VALID_JPEG
            );

            $commandHandler = $this->buildCreateBadgeCommandHandler(
                $this->buildTenantRepository($this->buildDefaultTenants()),
                $this->buildImageRepository(),
                $this->buildBadgeRepository(),
                $this->buildIdGenerator(),
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
                $this->buildTenantRepository($this->buildDefaultTenants()),
                $imageRepository,
                $this->buildBadgeRepository(),
                $this->buildIdGenerator(),
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
                $this->buildTenantRepository($this->buildDefaultTenants()),
                $this->buildImageRepository(),
                $badgeRepository,
                $this->buildIdGenerator(),
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
            $this->buildTenantRepository($this->buildDefaultTenants()),
            $imageRepository,
            $badgeRepository,
            $this->buildIdGenerator(),
            $this->buildBadgeDataTransformer()
        );
        $command = $this->buildCommand();

        /** @var Badge $badge */
        $badge = $commandHandler->handle($command);

        $this->assertTrue(
            $this->validateBadgeData($badge, $command)
            && $this->validateTenantData($badge->tenant(), $command->tenantData())
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
            static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
            static::TENANT_ID_VALID_1234,
            static::IMAGE_NAME_VALID_FLOWER,
            static::IMAGE_WIDTH_VALID_4,
            static::IMAGE_HEIGHT_VALID_5,
            static::IMAGE_FORMAT_VALID_JPEG
        );
    }

    private function buildCreateBadgeCommand(
        $badgeName,
        $badgeDescription,
        $badgeIsMultiTenant,
        $tenantId,
        $imageName,
        $imageWidth,
        $imageHeight,
        $imageFormat
    ) {
        return new CreateBadgeCommand(
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

    private function buildCreateBadgeCommandHandler(
        TenantRepository $tenantRepository,
        ImageRepository $imageRepository,
        BadgeRepository $badgeRepository,
        IdGenerator $idGenerator,
        BadgeDataTransformer $badgeDataTransformer
    ) {
        return new CreateBadgeCommandHandler(
            $tenantRepository,
            $imageRepository,
            $badgeRepository,
            $idGenerator,
            $badgeDataTransformer
        );
    }

    /**
     * @return Tenant[]
     */
    private function buildDefaultTenants()
    {
        return $this->buildTenants(
            static::TENANT_ID_VALID_1234,
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
