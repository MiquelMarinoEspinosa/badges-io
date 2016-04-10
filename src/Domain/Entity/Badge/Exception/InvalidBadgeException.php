<?php

namespace Domain\Entity\Badge\Exception;

use Domain\Exception\BaseException;

class InvalidBadgeException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_PROVIDED:
                $this->idNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED:
                $this->idNotValidProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED:
                $this->nameNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED:
                $this->nameNotValidProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED:
                $this->descriptionNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED:
                $this->descriptionNotValidProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_PROVIDED:
                $this->isMultiUserNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED:
                $this->isMultiUserNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidBadgeException
     */
    private function idNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function idNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function nameNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_NAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function nameNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_NAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function descriptionNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_DESCRIPTION_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function descriptionNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_DESCRIPTION_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function isMultiUserNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_IS_MULTI_USER_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function isMultiUserNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED);

        return $this;
    }
}
