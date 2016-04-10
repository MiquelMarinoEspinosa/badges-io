<?php

namespace Test\Interactor\CommandHandler\CreateBadge;

use Interactor\CommandHandler\CreateBadge\CreateBadgeCommand;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\Exception\InvalidImageDataException;
use Interactor\CommandHandler\CreateBadge\ImageData\Exception\InvalidImageDataExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\CommandHandler\CreateBadge\TenantData\Exception\InvalidTenantDataException;
use Interactor\CommandHandler\CreateBadge\TenantData\Exception\InvalidTenantDataExceptionCode;
use Interactor\CommandHandler\CreateBadge\TenantData\TenantData;

class CreateBadgeCommandTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_NAME_NOT_VALID_EMPTY             = ' ';
    const BADGE_NAME_NOT_VALID_INT               = 12;
    const BADGE_NAME_VALID_BADGE_NAME            = 'badgeName';
    const BADGE_DESCRIPTION_NOT_VALID_FLOAT      = 1.4;
    const BADGE_DESCRIPTION_VALID_EMPTY          = '';
    const BADGE_IS_MULTI_TENANT_NOT_VALID_STRING = 'aString';
    const BADGE_IS_MULTI_TENANT_VALID_TRUE       = true;
    const TENANT_ID_NOT_VALID_INT                = 3;
    const TENANT_ID_NOT_VALID_EMPTY              = ' ';
    const TENANT_ID_VALID_1234                   = '1234';
    const IMAGE_NAME_NOT_VALID_INT               = 23;
    const IMAGE_NAME_NOT_VALID_EMPTY             = ' ';
    const IMAGE_NAME_VALID_FLOWER                = 'flower';
    const IMAGE_WIDTH_NOT_VALID_BOOLEAN          = false;
    const IMAGE_WIDTH_NOT_VALID_MINUS_INTEGER    = -1;
    const IMAGE_WIDTH_VALID_4                    = 4;
    const IMAGE_HEIGHT_NOT_VALID_STRING          = 'string';
    const IMAGE_HEIGHT_NOT_VALID_MINUS_INT       = -2;
    const IMAGE_HEIGHT_VALID_5                   = 5;
    const IMAGE_FORMAT_NOT_VALID_HRX             = 'hrx';
    const IMAGE_FORMAT_VALID_JPEG                = 'jpeg';

    /**
     * @test
     */
    public function commandWithoutBadgeNameShouldThrownExceptionBadgeNameNotProvidedStatusCode()
    {
        try {
            $aNullBadgeName             = null;
            $aNullBadgeDescription      = null;
            $aNullBadgeIsMultiTenant    = null;
            $aNullTenantId              = null;
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                $aNullBadgeName,
                $aNullBadgeDescription,
                $aNullBadgeIsMultiTenant,
                $aNullTenantId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandException $invalidCreateBadgeCommandException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED,
                $invalidCreateBadgeCommandException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandNotValidBadgeNameTypeProvidedShouldThrownExceptionNameNotValidProvidedStatusCode()
    {
        try {
            $aNullBadgeDescription      = null;
            $aNullBadgeIsMultiTenant    = null;
            $aNullTenantId              = null;
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_NOT_VALID_INT,
                $aNullBadgeDescription,
                $aNullBadgeIsMultiTenant,
                $aNullTenantId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandException $invalidCreateBadgeCommandException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED,
                $invalidCreateBadgeCommandException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandNotValidBadgeNameProvidedShouldThrownExceptionNameNotValidProvidedStatusCode()
    {
        try {
            $aNullBadgeDescription      = null;
            $aNullBadgeIsMultiTenant    = null;
            $aNullTenantId              = null;
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_NOT_VALID_EMPTY,
                $aNullBadgeDescription,
                $aNullBadgeIsMultiTenant,
                $aNullTenantId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandException $invalidCreateBadgeCommandException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED,
                $invalidCreateBadgeCommandException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithoutBadgeDescriptionProvidedShouldThrownExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullBadgeDescription      = null;
            $aNullBadgeIsMultiTenant    = null;
            $aNullTenantId              = null;
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                $aNullBadgeDescription,
                $aNullBadgeIsMultiTenant,
                $aNullTenantId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandException $invalidCreateBadgeCommandException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED,
                $invalidCreateBadgeCommandException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandBadgeDescriptionTypeNotValidProvidedShouldThrownExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullBadgeIsMultiTenant    = null;
            $aNullTenantId              = null;
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_NOT_VALID_FLOAT,
                $aNullBadgeIsMultiTenant,
                $aNullTenantId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandException $invalidCreateBadgeCommandException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED,
                $invalidCreateBadgeCommandException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithoutIsMultiTenantProvidedShouldThrownExceptionIsMultiTenantNotValidProvidedStatusCode()
    {
        try {
            $aNullBadgeIsMultiTenant    = null;
            $aNullTenantId              = null;
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                $aNullBadgeIsMultiTenant,
                $aNullTenantId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandException $invalidCreateBadgeCommandException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_PROVIDED,
                $invalidCreateBadgeCommandException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandNotValidIsMultiTenantProvidedShouldThrownExceptionIsMultiTenantNotProvidedStatusCode()
    {
        try {
            $aNullTenantId              = null;
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_NOT_VALID_STRING,
                $aNullTenantId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidCreateBadgeCommandException $invalidCreateBadgeCommandException) {
            $this->assertEquals(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED,
                $invalidCreateBadgeCommandException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithoutTenantIdProvidedShouldThrownTenantDataExceptionIdNotProvidedStatusCode()
    {
        try {
            $aNullTenantId              = null;
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                $aNullTenantId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidTenantDataException $invalidTenantDataException) {
            $this->assertEquals(
                InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_PROVIDED,
                $invalidTenantDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithTenantIdNotValidTypeProvidedShouldThrownTenantDataExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_NOT_VALID_INT,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidTenantDataException $invalidTenantDataException) {
            $this->assertEquals(
                InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidTenantDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithTenantIdNotValidProvidedShouldThrownTenantDataExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_NOT_VALID_EMPTY,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidTenantDataException $invalidTenantDataException) {
            $this->assertEquals(
                InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidTenantDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithoutImageNameProvidedShouldThrownImageDataExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullImageName             = null;
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithImageNameNotValidTypeShouldThrownImageDataExceptionNameNotValidProvidedStatusCode()
    {
        try {
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_NOT_VALID_INT,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithImageNameNotValidShouldThrownImageDataExceptionNameNotValidProvidedStatusCode()
    {
        try {
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_NOT_VALID_EMPTY,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithoutImageWidthShouldThrownImageDataExceptionWidthNotProvidedStatusCode()
    {
        try {
            $aNullImageWidth            = null;
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithImageWidthTypeNotValidShouldThrownImageDataExceptionWidthNotValidProvidedStatusCode()
    {
        try {
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_NOT_VALID_BOOLEAN,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithImageWidthNotValidShouldThrownImageDataExceptionWidthNotValidProvidedStatusCode()
    {
        try {
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_NOT_VALID_MINUS_INTEGER,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithoutImageHeightShouldThrownImageDataExceptionHeightNotProvidedStatusCode()
    {
        try {
            $aNullImageHeight           = null;
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                $aNullImageHeight,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithImageHeightTypeNotValidShouldThrownImageDataExceptionHeightNotValidProvidedStatusCode()
    {
        try {
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_NOT_VALID_STRING,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandHeightImageWidthNotValidShouldThrownImageDataExceptionHeightNotValidProvidedStatusCode()
    {
        try {
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_NOT_VALID_MINUS_INT,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithoutFormatImageShouldThrownImageDataExceptionFormatNotProvidedStatusCode()
    {
        try {
            $aNullImageFormat           = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_VALID_5,
                $aNullImageFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_FORMAT_NOT_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithFormatNotValidImageShouldThrownImageDataExceptionFormatNotValidProvidedStatusCode()
    {
        try {
            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
                static::TENANT_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_VALID_5,
                static::IMAGE_FORMAT_NOT_VALID_HRX
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_FORMAT_NOT_VALID_PROVIDED,
                $invalidImageDataException->code()
            );
        }

    }

    /**
     * @test
     */
    public function commandWithAllTheParamsValidShouldReturnTheCommand()
    {
        $command = $this->buildCreateBadgeCommand(
            static::BADGE_NAME_VALID_BADGE_NAME,
            static::BADGE_DESCRIPTION_VALID_EMPTY,
            static::BADGE_IS_MULTI_TENANT_VALID_TRUE,
            static::TENANT_ID_VALID_1234,
            static::IMAGE_NAME_VALID_FLOWER,
            static::IMAGE_WIDTH_VALID_4,
            static::IMAGE_HEIGHT_VALID_5,
            static::IMAGE_FORMAT_VALID_JPEG
        );

        $this->assertTrue(
            $command->name() === static::BADGE_NAME_VALID_BADGE_NAME
            && $command->description() === static::BADGE_DESCRIPTION_VALID_EMPTY
            && $command->isMultiUser() === static::BADGE_IS_MULTI_TENANT_VALID_TRUE
            && $command->tenantData()->id() === static::TENANT_ID_VALID_1234
            && $command->imageData()->name() === static::IMAGE_NAME_VALID_FLOWER
            && $command->imageData()->width() === static::IMAGE_WIDTH_VALID_4
            && $command->imageData()->height() === static::IMAGE_HEIGHT_VALID_5
            && $command->imageData()->format() === static::IMAGE_FORMAT_VALID_JPEG
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

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
