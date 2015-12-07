<?php

namespace Domain\Entity\Image\Exception;

use Domain\Exception\BaseException;

class InvalidImageException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidImageExceptionCode::STATUS_CODE_ID_NOT_PROVIDED:
                $this->idNotProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED:
                $this->idNotValidProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED:
                $this->nameNotProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED:
                $this->nameNotValidProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_PROVIDED:
                $this->widthNotProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED:
                $this->widthNotValidProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_PROVIDED:
                $this->heightNotProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED:
                $this->heightNotValidProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_FORMAT_NOT_PROVIDED:
                $this->formatNotProvided();
                break;
            case InvalidImageExceptionCode::STATUS_CODE_FORMAT_NOT_VALID_PROVIDED:
                $this->formatNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidImageException
     */
    private function idNotProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_ID_NOT_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_ID_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function idNotValidProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function nameNotProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_NAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function nameNotValidProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_NAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function widthNotProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_WIDTH_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function widthNotValidProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_WIDTH_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_WIDTH_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function heightNotProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_HEIGHT_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function heightNotValidProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_HEIGHT_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function formatNotProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_FORMAT_NOT_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_FORMAT_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidImageException
     */
    private function formatNotValidProvided()
    {
        $this->setCode(InvalidImageExceptionCode::STATUS_CODE_FORMAT_NOT_VALID_PROVIDED)
             ->setMessage(InvalidImageExceptionCode::MESSAGE_CODE_FORMAT_NOT_VALID_PROVIDED);

        return $this;
    }
}
