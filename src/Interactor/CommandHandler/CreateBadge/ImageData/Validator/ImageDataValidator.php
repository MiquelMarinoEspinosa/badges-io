<?php

namespace Interactor\CommandHandler\CreateBadge\ImageData\Validator;

use Interactor\CommandHandler\CreateBadge\ImageData\Exception\InvalidImageDataException;
use Interactor\CommandHandler\CreateBadge\ImageData\Exception\InvalidImageDataExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\Validator\Validator;

class ImageDataValidator implements Validator
{
    private $formatsAllowed = [
        'jpeg',
        'tiff',
        'gif',
        'bmp',
        'png'
    ];

    /**
     * @var ImageData
     */
    private $imageData;

    public function __construct(ImageData $imageData)
    {
        $this->imageData = $imageData;
    }

    public function validate()
    {
        $this->validateName()
             ->validateWidth()
             ->validateHeight()
             ->validateFormat()
             ->validatePath();
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function validateName()
    {
        $this->checkNameIsNotNull()
              ->checkNameFormat();

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkNameIsNotNull()
    {
        $aNullName = null;
        if ($this->imageData->name() === $aNullName) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkNameFormat()
    {
        if ($this->notValidNameFormat($this->imageData->name())) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED
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
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function validateWidth()
    {
        $this->checkWidthNotNull()
              ->checkWidthFormat();

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkWidthNotNull()
    {
        $aNullWidth = null;
        if ($this->imageData->width() === $aNullWidth) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkWidthFormat()
    {
        if ($this->notValidWidthFormat($this->imageData->width())) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED
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
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function validateHeight()
    {
        $this->checkHeightNotNull()
             ->checkHeightFormat();

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkHeightNotNull()
    {
        $aNullHeight = null;
        if ($this->imageData->height() === $aNullHeight) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkHeightFormat()
    {
        if ($this->notValidHeightFormat($this->imageData->height())) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED
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
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function validateFormat()
    {
        $this->checkFormatNotNull()
             ->checkFormatIsValid();

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkFormatNotNull()
    {
        $aNullFormat = null;
        if ($this->imageData->format() === $aNullFormat) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_FORMAT_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkFormatIsValid()
    {
        if ($this->isNotFormatAllowed($this->imageData->format())) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_FORMAT_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }


    /**
     * @param string $format
     *
     * @return bool
     */
    private function isNotFormatAllowed($format)
    {
        return !in_array($format, $this->formatsAllowed);
    }

    private function validatePath()
    {
        $this->checkPathNotNull()
             ->checkPathFormat();
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkPathNotNull()
    {
        $aNullPath = null;
        if ($this->imageData->path() === $aNullPath) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_PATH_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ImageDataValidator
     * @throws InvalidImageDataException
     */
    private function checkPathFormat()
    {
        if ($this->isNotValidPath($this->imageData->path())) {
            throw $this->buildInvalidImageDataException(
                InvalidImageDataExceptionCode::STATUS_CODE_PATH_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    private function isNotValidPath($name)
    {
        return !is_string($name) || '' === trim($name);
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidImageDataException
     */
    private function buildInvalidImageDataException($statusCode)
    {
        return new InvalidImageDataException($statusCode);
    }
}
