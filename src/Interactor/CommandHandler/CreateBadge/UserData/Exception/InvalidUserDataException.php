<?php

namespace Interactor\CommandHandler\CreateBadge\UserData\Exception;

use Interactor\Exception\BaseException;

class InvalidUserDataException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_PROVIDED:
                $this->idNotProvided();
                break;
            case InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED:
                $this->idNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidUserDataException
     */
    private function idNotProvided()
    {
        $this->setCode(InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_PROVIDED)
             ->setMessage(InvalidUserDataExceptionCode::MESSAGE_CODE_ID_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUserDataException
     */
    private function idNotValidProvided()
    {
        $this->setCode(InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED)
            ->setMessage(InvalidUserDataExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }
}
