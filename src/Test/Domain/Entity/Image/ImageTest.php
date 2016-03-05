<?php

namespace Test\Domain\Image;

use Domain\Entity\Image\Exception\InvalidImageException;
use Domain\Entity\Image\Exception\InvalidImageExceptionCode;
use Domain\Entity\Image\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    const ID_NOT_VALID_INT              = 3;
    const ID_NOT_VALID_EMPTY            = ' ';
    const ID_VALID_1234                 = '1234';
    const NAME_NOT_VALID_INT            = 23;
    const NAME_NOT_VALID_EMPTY          = ' ';
    const NAME_VALID_FLOWER             = 'flower';
    const WIDTH_NOT_VALID_BOOLEAN       = false;
    const WIDTH_NOT_VALID_MINUS_INTEGER = -1;
    const WIDTH_VALID_4                 = 4;
    const HEIGHT_NOT_VALID_STRING       = 'string';
    const HEIGHT_NOT_VALID_MINUS_INT    = -2;
    const HEIGHT_VALID_5                = 5;
    const FORMAT_NOT_VALID_HRX          = 'hrx';
    const FORMAT_VALID_JPEG             = 'jpeg';

    /**
     * @test
     */
    public function notIdProvidedShouldThrownExceptionIdNotProvidedStatusCode()
    {
        try {
            $aNullId     = null;
            $aNullName   = null;
            $aNullWidth  = null;
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                $aNullId,
                $aNullName,
                $aNullWidth,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_ID_NOT_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidIdTypeProvidedShouldThrownExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullName   = null;
            $aNullWidth  = null;
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                static::ID_NOT_VALID_INT,
                $aNullName,
                $aNullWidth,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidIdProvidedShouldThrownExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullName   = null;
            $aNullWidth  = null;
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                static::ID_NOT_VALID_EMPTY,
                $aNullName,
                $aNullWidth,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notNameProvidedShouldThrownExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullName   = null;
            $aNullWidth  = null;
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                self::ID_VALID_1234,
                $aNullName,
                $aNullWidth,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidNameTypeProvidedShouldThrownExceptionNameNotValidProvidedStatusCode()
    {
        try {
            $aNullWidth  = null;
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_NOT_VALID_INT,
                $aNullWidth,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidImageNameShouldThrownExceptionNameNotValidProvidedStatusCode()
    {
        try {
            $aNullWidth  = null;
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_NOT_VALID_EMPTY,
                $aNullWidth,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notWidthProvidedShouldThrownExceptionWidthNotProvidedStatusCode()
    {
        try {
            $aNullWidth  = null;
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_VALID_FLOWER,
                $aNullWidth,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidWidthTypeProvidedShouldThrownExceptionWidthNotValidProvidedStatusCode()
    {
        try {
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_VALID_FLOWER,
                static::WIDTH_NOT_VALID_BOOLEAN,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidWidthProvidedShouldThrownExceptionWidthNotValidProvidedStatusCode()
    {
        try {
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_VALID_FLOWER,
                static::WIDTH_NOT_VALID_MINUS_INTEGER,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notHeightProvidedShouldThrownExceptionHeightNotProvidedStatusCode()
    {
        try {
            $aNullHeight = null;
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_VALID_FLOWER,
                static::WIDTH_VALID_4,
                $aNullHeight,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidHeightProvidedTypeShouldThrownExceptionHeightNotValidProvidedStatusCode()
    {
        try {
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_VALID_FLOWER,
                static::WIDTH_VALID_4,
                static::HEIGHT_NOT_VALID_STRING,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidHeightProvidedShouldThrownExceptionHeightNotValidProvidedStatusCode()
    {
        try {
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_VALID_FLOWER,
                static::WIDTH_VALID_4,
                static::HEIGHT_NOT_VALID_MINUS_INT,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notFormatProvidedShouldThrownExceptionFormatNotProvidedStatusCode()
    {
        try {
            $aNullFormat = null;

            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_VALID_FLOWER,
                static::WIDTH_VALID_4,
                static::HEIGHT_VALID_5,
                $aNullFormat
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_FORMAT_NOT_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function notValidFormatProvidedShouldThrownExceptionFormatNotValidProvidedStatusCode()
    {
        try {
            $this->buildImage(
                static::ID_VALID_1234,
                static::NAME_VALID_FLOWER,
                static::WIDTH_VALID_4,
                static::HEIGHT_VALID_5,
                static::FORMAT_NOT_VALID_HRX
            );
            $this->thisTestFails();
        } catch (InvalidImageException $invalidImageException) {
            $this->assertEquals(
                InvalidImageExceptionCode::STATUS_CODE_FORMAT_NOT_VALID_PROVIDED,
                $invalidImageException->code()
            );
        }

    }

    /**
     * @test
     */
    public function validParametersShouldReturnTheImage()
    {
        $image = $this->buildImage(
            static::ID_VALID_1234,
            static::NAME_VALID_FLOWER,
            static::WIDTH_VALID_4,
            static::HEIGHT_VALID_5,
            static::FORMAT_VALID_JPEG
        );

        $this->assertTrue(
            $image->id() === static::ID_VALID_1234
            && $image->name() === static::NAME_VALID_FLOWER
            && $image->width() === static::WIDTH_VALID_4
            && $image->height() === static::HEIGHT_VALID_5
            && $image->format() === static::FORMAT_VALID_JPEG
        );
    }

    /**
     * @param string $id
     * @param string $name
     * @param int $width
     * @param int $height
     * @param string $format
     *
     * @return Image
     */
    private function buildImage($id, $name, $width, $height, $format)
    {
        return new Image($id, $name, $width, $height, $format);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
