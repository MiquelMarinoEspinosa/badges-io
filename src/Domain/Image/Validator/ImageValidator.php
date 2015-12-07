<?php

namespace Domain\Image\Validator;

use Domain\Image\Exception\InvalidImageException;
use Domain\Image\Exception\InvalidImageExceptionCode;
use Domain\Image\Image;
use Validator\Validator;

class ImageValidator implements Validator
{
    private $formatsAllowed = [
        'jpeg',
        'tiff',
        'gif',
        'bmp',
        'png'
    ];

    /**
     * @var Image
     */
    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function validate()
    {
        $this->validateId()
             ->validateName()
             ->validateWidth()
             ->validateHeight()
             ->validateFormat();
    }

    /**
     * @throws InvalidImageException
     */
    private function validateId()
    {
        $this->checkIdIsNotNull()
             ->checkIdFormat();

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkIdIsNotNull()
    {
        $aNullId = null;
        if ($this->image->id() === $aNullId) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkIdFormat()
    {
        if ($this->notValidIdFormat($this->image->id())) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    private function notValidIdFormat($id)
    {
        return !is_string($id) || '' === trim($id);
    }


    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function validateName()
    {
        $this->checkNameIsNotNull()
             ->checkNameFormat();

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkNameIsNotNull()
    {
        $aNullName = null;
        if ($this->image->name() === $aNullName) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkNameFormat()
    {
        if ($this->notValidNameFormat($this->image->name())) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    private function notValidNameFormat($name)
    {
        return !is_string($name) || '' === trim($name);
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function validateWidth()
    {
        $this->checkWidthNotNull()
             ->checkWidthFormat();

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkWidthNotNull()
    {
        $aNullWidth = null;
        if ($this->image->width() === $aNullWidth) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkWidthFormat()
    {
        if ($this->notValidWidthFormat($this->image->width())) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $width
     *
     * @return bool
     */
    private function notValidWidthFormat($width)
    {
        return !is_int($width) || $width < 0;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function validateHeight()
    {
        $this->checkHeightNotNull()
             ->checkHeightFormat();

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkHeightNotNull()
    {
        $aNullHeight = null;
        if ($this->image->height() === $aNullHeight) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkHeightFormat()
    {
        if ($this->notValidHeightFormat($this->image->height())) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $height
     *
     * @return bool
     */
    private function notValidHeightFormat($height)
    {
        return !is_int($height) || $height < 0;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function validateFormat()
    {
        $this->checkFormatNotNull()
             ->checkFormatIsValid();

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkFormatNotNull()
    {
        $aNullFormat = null;
        if ($this->image->format() === $aNullFormat) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_FORMAT_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageValidator
     * @throws InvalidImageException
     */
    private function checkFormatIsValid()
    {
        if ($this->isNotFormatAllowed($this->image->format())) {
            throw $this->buildInvalidImageException(
                InvalidImageExceptionCode::STATUS_CODE_FORMAT_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }


    private function isNotFormatAllowed($format)
    {
        return !in_array($format, $this->formatsAllowed);
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidImageException
     */
    private function buildInvalidImageException($statusCode)
    {
        return new InvalidImageException($statusCode);
    }
}
