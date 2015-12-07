<?php

namespace Interactor\CommandHandler\CreateBadge\ImageData\Exception;

use Interactor\Exception\BaseException;

class InvalidImageDataException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED:
                $this->nameNotProvided();
                break;
            case InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED:
                $this->nameNotValidProvided();
                break;
            case InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_PROVIDED:
                $this->widthNotProvided();
                break;
            case InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED:
                $this->widthNotValidProvided();
                break;
            case InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_PROVIDED:
                $this->heightNotProvided();
                break;
            case InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED:
                $this->heightNotValidProvided();
                break;
            case InvalidImageDataExceptionCode::STATUS_CODE_FORMAT_NOT_PROVIDED:
                $this->formatNotProvided();
                break;
            case InvalidImageDataExceptionCode::STATUS_CODE_FORMAT_NOT_VALID_PROVIDED:
                $this->formatNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidImageDataException
     */
    private function nameNotProvided()
    {
        $this->setCode(InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED)
             ->setMessage(InvalidImageDataExceptionCode::MESSAGE_CODE_NAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageDataException
     */
    private function nameNotValidProvided()
    {
        $this->setCode(InvalidImageDataExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageDataExceptionCode::MESSAGE_CODE_NAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageDataException
     */
    private function widthNotProvided()
    {
        $this->setCode(InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_PROVIDED)
             ->setMessage(InvalidImageDataExceptionCode::MESSAGE_CODE_WIDTH_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageDataException
     */
    private function widthNotValidProvided()
    {
        $this->setCode(InvalidImageDataExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageDataExceptionCode::MESSAGE_CODE_WIDTH_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageDataException
     */
    private function heightNotProvided()
    {
        $this->setCode(InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_PROVIDED)
             ->setMessage(InvalidImageDataExceptionCode::MESSAGE_CODE_HEIGHT_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageDataException
     */
    private function heightNotValidProvided()
    {
        $this->setCode(InvalidImageDataExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageDataExceptionCode::MESSAGE_CODE_HEIGHT_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageDataException
     */
    private function formatNotProvided()
    {
        $this->setCode(InvalidImageDataExceptionCode::STATUS_CODE_FORMAT_NOT_PROVIDED)
             ->setMessage(InvalidImageDataExceptionCode::MESSAGE_CODE_FORMAT_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageDataException
     */
    private function formatNotValidProvided()
    {
        $this->setCode(InvalidImageDataExceptionCode::STATUS_CODE_FORMAT_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageDataExceptionCode::MESSAGE_CODE_FORMAT_NOT_VALID_PROVIDED);

        return $this;
    }
}
