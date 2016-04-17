<?php

namespace Test\Interactor\CommandHandler\CreateBadge;

use Interactor\CommandHandler\CreateBadge\CreateBadgeCommand;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\Exception\InvalidImageDataException;
use Interactor\CommandHandler\CreateBadge\ImageData\Exception\InvalidImageDataExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\CommandHandler\CreateBadge\UserData\Exception\InvalidUserDataException;
use Interactor\CommandHandler\CreateBadge\UserData\Exception\InvalidUserDataExceptionCode;
use Interactor\CommandHandler\CreateBadge\UserData\UserData;

class CreateBadgeCommandTest extends \PHPUnit_Framework_TestCase
{
    const BADGE_NAME_NOT_VALID_EMPTY           = ' ';
    const BADGE_NAME_NOT_VALID_INT             = 12;
    const BADGE_NAME_VALID_BADGE_NAME          = 'badgeName';
    const BADGE_DESCRIPTION_NOT_VALID_FLOAT    = 1.4;
    const BADGE_DESCRIPTION_VALID_EMPTY        = '';
    const BADGE_IS_MULTI_USER_NOT_VALID_STRING = 'aString';
    const BADGE_IS_MULTI_USER_VALID_TRUE       = true;
    const USER_ID_NOT_VALID_INT                = 3;
    const USER_ID_NOT_VALID_EMPTY              = ' ';
    const USER_ID_VALID_1234                   = '1234';
    const IMAGE_NAME_NOT_VALID_INT             = 23;
    const IMAGE_NAME_NOT_VALID_EMPTY           = ' ';
    const IMAGE_NAME_VALID_FLOWER              = 'flower';
    const IMAGE_WIDTH_NOT_VALID_BOOLEAN        = false;
    const IMAGE_WIDTH_NOT_VALID_MINUS_INTEGER  = -1;
    const IMAGE_WIDTH_VALID_4                  = 4;
    const IMAGE_HEIGHT_NOT_VALID_STRING        = 'string';
    const IMAGE_HEIGHT_NOT_VALID_MINUS_INT     = -2;
    const IMAGE_HEIGHT_VALID_5                 = 5;
    const IMAGE_FORMAT_NOT_VALID_HRX           = 'hrx';
    const IMAGE_FORMAT_VALID_JPEG              = 'jpeg';
    const IMAGE_PATH_NOT_VALID_INT_1           = 1;
    const IMAGE_VALID_PATH_TMP_X452            = '/tmp/x452';

    /**
     * @test
     */
    public function commandWithoutBadgeNameShouldThrownExceptionBadgeNameNotProvidedStatusCode()
    {
        try {
            $aNullBadgeName         = null;
            $aNullBadgeDescription  = null;
            $aNullBadgeIsMultiUser  = null;
            $aNullUserId            = null;
            $aNullImageName         = null;
            $aNullImageWidth        = null;
            $aNullImageHeight       = null;
            $aNullImageFormat       = null;
            $aNullImagePath         = null;

            $this->buildCreateBadgeCommand(
                $aNullBadgeName,
                $aNullBadgeDescription,
                $aNullBadgeIsMultiUser,
                $aNullUserId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullBadgeDescription  = null;
            $aNullBadgeIsMultiUser  = null;
            $aNullUserId            = null;
            $aNullImageName         = null;
            $aNullImageWidth        = null;
            $aNullImageHeight       = null;
            $aNullImageFormat       = null;
            $aNullImagePath         = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_NOT_VALID_INT,
                $aNullBadgeDescription,
                $aNullBadgeIsMultiUser,
                $aNullUserId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullBadgeDescription  = null;
            $aNullBadgeIsMultiUser  = null;
            $aNullUserId            = null;
            $aNullImageName         = null;
            $aNullImageWidth        = null;
            $aNullImageHeight       = null;
            $aNullImageFormat       = null;
            $aNullImagePath         = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_NOT_VALID_EMPTY,
                $aNullBadgeDescription,
                $aNullBadgeIsMultiUser,
                $aNullUserId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullBadgeDescription  = null;
            $aNullBadgeIsMultiUser  = null;
            $aNullUserId            = null;
            $aNullImageName         = null;
            $aNullImageWidth        = null;
            $aNullImageHeight       = null;
            $aNullImageFormat       = null;
            $aNullImagePath         = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                $aNullBadgeDescription,
                $aNullBadgeIsMultiUser,
                $aNullUserId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullBadgeIsMultiUser  = null;
            $aNullUserId            = null;
            $aNullImageName         = null;
            $aNullImageWidth        = null;
            $aNullImageHeight       = null;
            $aNullImageFormat       = null;
            $aNullImagePath         = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_NOT_VALID_FLOAT,
                $aNullBadgeIsMultiUser,
                $aNullUserId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
    public function commandWithoutIsMultiUserProvidedShouldThrownExceptionIsMultiUserNotValidProvidedStatusCode()
    {
        try {
            $aNullBadgeIsMultiUser  = null;
            $aNullUserId            = null;
            $aNullImageName         = null;
            $aNullImageWidth        = null;
            $aNullImageHeight       = null;
            $aNullImageFormat       = null;
            $aNullImagePath         = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                $aNullBadgeIsMultiUser,
                $aNullUserId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
    public function commandNotValidIsMultiUserProvidedShouldThrownExceptionIsMultiUserNotProvidedStatusCode()
    {
        try {
            $aNullUserId      = null;
            $aNullImageName   = null;
            $aNullImageWidth  = null;
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_NOT_VALID_STRING,
                $aNullUserId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
    public function commandWithoutUserIdProvidedShouldThrownUserDataExceptionIdNotProvidedStatusCode()
    {
        try {
            $aNullUserId      = null;
            $aNullImageName   = null;
            $aNullImageWidth  = null;
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                $aNullUserId,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
            );
            $this->thisTestFails();
        } catch (InvalidUserDataException $invalidUserDataException) {
            $this->assertEquals(
                InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_PROVIDED,
                $invalidUserDataException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithUserIdNotValidTypeProvidedShouldThrownUserDataExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullImageName   = null;
            $aNullImageWidth  = null;
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_NOT_VALID_INT,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
            );
            $this->thisTestFails();
        } catch (InvalidUserDataException $invalidUserDataException) {
            $this->assertEquals(
                InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidUserDataException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithUserIdNotValidProvidedShouldThrownUserDataExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullImageName   = null;
            $aNullImageWidth  = null;
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_NOT_VALID_EMPTY,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
            );
            $this->thisTestFails();
        } catch (InvalidUserDataException $invalidUserDataException) {
            $this->assertEquals(
                InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidUserDataException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithoutImageNameProvidedShouldThrownImageDataExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullImageName   = null;
            $aNullImageWidth  = null;
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                $aNullImageName,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageWidth  = null;
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_NOT_VALID_INT,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageWidth  = null;
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_NOT_VALID_EMPTY,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageWidth  = null;
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                $aNullImageWidth,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_NOT_VALID_BOOLEAN,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_NOT_VALID_MINUS_INTEGER,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageHeight = null;
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                $aNullImageHeight,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_NOT_VALID_STRING,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_NOT_VALID_MINUS_INT,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImageFormat = null;
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_VALID_5,
                $aNullImageFormat,
                $aNullImagePath
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
            $aNullImagePath = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_VALID_5,
                static::IMAGE_FORMAT_NOT_VALID_HRX,
                $aNullImagePath
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
    public function commandWithoutPathImageShouldThrownImageDataExceptionPAthNotProvidedStatusCode()
    {
        try {
            $aNullImagePath   = null;

            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_VALID_5,
                static::IMAGE_FORMAT_VALID_JPEG,
                $aNullImagePath
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_PATH_NOT_PROVIDED,
                $invalidImageDataException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithPathNotValidImageShouldThrownImageDataExceptionPathNotValidProvidedStatusCode()
    {
        try {
            $this->buildCreateBadgeCommand(
                static::BADGE_NAME_VALID_BADGE_NAME,
                static::BADGE_DESCRIPTION_VALID_EMPTY,
                static::BADGE_IS_MULTI_USER_VALID_TRUE,
                static::USER_ID_VALID_1234,
                static::IMAGE_NAME_VALID_FLOWER,
                static::IMAGE_WIDTH_VALID_4,
                static::IMAGE_HEIGHT_VALID_5,
                static::IMAGE_FORMAT_VALID_JPEG,
                static::IMAGE_PATH_NOT_VALID_INT_1
            );
            $this->thisTestFails();
        } catch (InvalidImageDataException $invalidImageDataException) {
            $this->assertEquals(
                InvalidImageDataExceptionCode::STATUS_CODE_PATH_NOT_VALID_PROVIDED,
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
            static::BADGE_IS_MULTI_USER_VALID_TRUE,
            static::USER_ID_VALID_1234,
            static::IMAGE_NAME_VALID_FLOWER,
            static::IMAGE_WIDTH_VALID_4,
            static::IMAGE_HEIGHT_VALID_5,
            static::IMAGE_FORMAT_VALID_JPEG,
            static::IMAGE_VALID_PATH_TMP_X452
        );

        $this->assertTrue(
            $command->name()                    === static::BADGE_NAME_VALID_BADGE_NAME
            && $command->description()          === static::BADGE_DESCRIPTION_VALID_EMPTY
            && $command->isMultiUser()          === static::BADGE_IS_MULTI_USER_VALID_TRUE
            && $command->UserData()->id()       === static::USER_ID_VALID_1234
            && $command->imageData()->name()    === static::IMAGE_NAME_VALID_FLOWER
            && $command->imageData()->width()   === static::IMAGE_WIDTH_VALID_4
            && $command->imageData()->height()  === static::IMAGE_HEIGHT_VALID_5
            && $command->imageData()->format()  === static::IMAGE_FORMAT_VALID_JPEG
            && $command->imageData()->path()    === static::IMAGE_VALID_PATH_TMP_X452
        );
    }

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

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
