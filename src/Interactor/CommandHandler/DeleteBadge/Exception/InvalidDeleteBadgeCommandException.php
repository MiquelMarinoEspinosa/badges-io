<?php

namespace Interactor\CommandHandler\DeleteBadge\Exception;

use Interactor\Exception\BaseException;

class InvalidDeleteBadgeCommandException extends BaseException
{
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_PROVIDED:
                $this->badgeIdNotProvided();
                break;
            case InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED:
                $this->badgeIdNotValidProvided();
                break;
            case InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED:
                $this->userIdNotProvided();
                break;
            case InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED:
                $this->userIdNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    private function badgeIdNotProvided()
    {
        $this->setCode(InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_PROVIDED)
             ->setMessage(InvalidDeleteBadgeCommandExceptionCode::MESSAGE_CODE_BADGE_ID_NOT_PROVIDED);
    }

    private function badgeIdNotValidProvided()
    {
        $this->setCode(InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidDeleteBadgeCommandExceptionCode::MESSAGE_CODE_BADGE_ID_NOT_VALID_PROVIDED);
    }

    private function userIdNotProvided()
    {
        $this->setCode(InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED)
             ->setMessage(InvalidDeleteBadgeCommandExceptionCode::MESSAGE_CODE_USER_ID_NOT_PROVIDED);
    }

    private function userIdNotValidProvided()
    {
        $this->setCode(InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidDeleteBadgeCommandExceptionCode::MESSAGE_CODE_USER_ID_NOT_VALID_PROVIDED);
    }
}
