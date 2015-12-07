<?php

namespace Test\Domain\Badge;

use Domain\Badge\Badge;
use Domain\Badge\Exception\InvalidBadgeException;
use Domain\Badge\Exception\InvalidBadgeExceptionCode;
use Domain\Image\Image;
use Domain\Tenant\Tenant;
use Test\Domain\Image\FakeImageBuilder;
use Test\Domain\Tenant\FakeTenantBuilder;

class BadgeTest extends \PHPUnit_Framework_TestCase
{
    const ID_NOT_VALID_EMPTY               = ' ';
    const ID_NOT_VALID_INT                 = 13;
    const ID_VALID_1234                    = '1234';
    const NAME_NOT_VALID_EMPTY             = ' ';
    const NAME_NOT_VALID_INT               = 12;
    const NAME_VALID_BADGE_NAME            = 'badgeName';
    const DESCRIPTION_NOT_VALID_FLOAT      = 1.4;
    const DESCRIPTION_VALID_EMPTY          = '';
    const IS_MULTI_TENANT_NOT_VALID_STRING = 'aString';
    const IS_MULTI_TENANT_VALID_TRUE       = true;
    const IS_MULTI_TENANT_VALID_FALSE      = false;
    const TENANT_ID_1234                   = '1234';
    const TENANT_EMAIL_TEST_BADGES_IO_COM  = 'test@badges-io.com';
    const TENANT_USERNAME_BADGES_TENANT    = 'badgesTenant';
    const TENANT_PASSWORD_BE_FREE          = 'B3FR33';
    const TENANT_ID_12345                  = '1235';
    const TENANT_EMAIL_TEST_BADGES_COM     = 'test@badges.com';
    const TENANT_USERNAME_TENANT           = 'tenant';
    const TENANT_PASSWORD_BE_COOL          = 'B3C10L';
    const IMAGE_ID_4321                    = '4321';
    const IMAGE_NAME_FLOWER                = 'flower';
    const IMAGE_WIDTH_4                    = 4;
    const IMAGE_HEIGHT_5                   = 5;
    const IMAGE_FORMAT_JPEG                = 'jpeg';
    const TENANT_NOT_VALID_INT_1           = 1;

    /**
     * @test
     */
    public function notIdProvidedShouldThrownExceptionIdNotProvidedStatusCode()
    {
        try {
            $aNullId            = null;
            $aNullName          = null;
            $aNullDescription   = null;
            $aNullIsMultiTenant = null;
            $aNullTenants       = null;

            $this->buildBadge(
                $aNullId,
                $aNullName,
                $aNullDescription,
                $aNullIsMultiTenant,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidIdTypeProvidedShouldThrownExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullName          = null;
            $aNullDescription   = null;
            $aNullIsMultiTenant = null;
            $aNullTenants       = null;

            $this->buildBadge(
                static::ID_NOT_VALID_INT,
                $aNullName,
                $aNullDescription,
                $aNullIsMultiTenant,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidIdProvidedShouldThrownExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullName          = null;
            $aNullDescription   = null;
            $aNullIsMultiTenant = null;
            $aNullTenants       = null;

            $this->buildBadge(
                static::ID_NOT_VALID_EMPTY,
                $aNullName,
                $aNullDescription,
                $aNullIsMultiTenant,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notNameProvidedShouldThrownExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullName          = null;
            $aNullDescription   = null;
            $aNullIsMultiTenant = null;
            $aNullTenants       = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                $aNullName,
                $aNullDescription,
                $aNullIsMultiTenant,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidNameProvidedShouldThrownExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullDescription   = null;
            $aNullIsMultiTenant = null;
            $aNullTenants       = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_NOT_VALID_EMPTY,
                $aNullDescription,
                $aNullIsMultiTenant,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notDescriptionProvidedShouldThrownExceptionDescriptionNotProvidedStatusCode()
    {
        try {
            $aNullDescription   = null;
            $aNullIsMultiTenant = null;
            $aNullTenants       = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                $aNullDescription,
                $aNullIsMultiTenant,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidDescriptionTypeProvidedShouldThrownExceptionDescriptionNotValidProvidedStatusCode()
    {
        try {
            $aNullIsMultiTenant = null;
            $aNullTenants       = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_NOT_VALID_FLOAT,
                $aNullIsMultiTenant,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notIsMultiTenantProvidedShouldThrownExceptionIsMultiTenantNotProvidedStatusCode()
    {
        try {
            $aNullIsMultiTenant = null;
            $aNullTenants       = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_VALID_EMPTY,
                $aNullIsMultiTenant,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidIsMultiTenantTypeProvidedShouldThrownExceptionIsMultiTenantNotValidProvidedStatusCode()
    {
        try {
            $aNullTenants = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_VALID_EMPTY,
                static::IS_MULTI_TENANT_NOT_VALID_STRING,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notTenantsProvidedShouldThrownExceptionTenantsNotProvidedStatusCode()
    {
        try {
            $aNullTenants = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_VALID_EMPTY,
                static::IS_MULTI_TENANT_VALID_TRUE,
                $aNullTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidTenantsArrayTypeShouldThrownExceptionTenantsNotValidProvidedStatusCode()
    {
        try {
            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_VALID_EMPTY,
                static::IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_NOT_VALID_INT_1
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidTenantsTypeShouldThrownExceptionTenantsNotValidProvidedStatusCode()
    {
        try {
            $notValidTenants = array_merge($this->buildTenants(), [static::TENANT_NOT_VALID_INT_1]);

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_VALID_EMPTY,
                static::IS_MULTI_TENANT_VALID_TRUE,
                $notValidTenants
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function tooManyTenantsProvidedShouldThrownExceptionTenantsNotValidProvidedStatusCode()
    {
        try {
            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_VALID_EMPTY,
                static::IS_MULTI_TENANT_VALID_FALSE,
                $this->buildTenants()
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function validParametersShouldReturnTheBadge()
    {
        $badge= $this->buildBadge(
            static::ID_VALID_1234,
            static::NAME_VALID_BADGE_NAME,
            static::DESCRIPTION_VALID_EMPTY,
            static::IS_MULTI_TENANT_VALID_TRUE,
            $this->buildTenants()
        );

        $this->assertTrue(
            $badge->id() === static::ID_VALID_1234
            && $badge->name() === static::NAME_VALID_BADGE_NAME
            && $badge->description() === static::DESCRIPTION_VALID_EMPTY
            && $badge->isMultiTenant() === static::IS_MULTI_TENANT_VALID_TRUE
            && $badge->image() instanceof Image
        );

        $this->assertContainsOnlyInstancesOf(
            Tenant::class,
            $badge->tenants()
        );
    }

    private function buildBadge(
        $id,
        $name,
        $description,
        $isMultiTenant,
        $tenants
    ) {
        return new Badge(
            $id,
            $name,
            $description,
            $isMultiTenant,
            $tenants,
            $this->buildImage()
        );
    }

    /**
     * @return Tenant[]
     */
    private function buildTenants()
    {
        return [
            FakeTenantBuilder::build(
                static::TENANT_ID_1234,
                static::TENANT_EMAIL_TEST_BADGES_IO_COM,
                static::TENANT_USERNAME_BADGES_TENANT,
                static::TENANT_PASSWORD_BE_FREE
            ),
            FakeTenantBuilder::build(
                static::TENANT_ID_12345,
                static::TENANT_EMAIL_TEST_BADGES_COM,
                static::TENANT_USERNAME_TENANT,
                static::TENANT_PASSWORD_BE_COOL
            )
        ];
    }

    /**
     * @return Image
     */
    private function buildImage()
    {
        return FakeImageBuilder::build(
            static::IMAGE_ID_4321,
            static::IMAGE_NAME_FLOWER,
            static::IMAGE_WIDTH_4,
            static::IMAGE_HEIGHT_5,
            static::IMAGE_FORMAT_JPEG
        );
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
