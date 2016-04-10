<?php

namespace Interactor\CommandHandler\GetBadge\Exception;

use Interactor\Exception\BaseException;

class InvalidGetBadgeCommandException extends BaseException
{
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_PROVIDED:
                $this->badgeIdNotProvided();
                break;
            case InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED:
                $this->badgeIdNotValidProvided();
                break;
            case InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED:
                $this->userIdNotProvided();
                break;
            case InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED:
                $this->userIdNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    private function badgeIdNotProvided()
    {
        $this->setCode(InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_PROVIDED)
             ->setMessage(InvalidGetBadgeCommandExceptionCode::MESSAGE_CODE_BADGE_ID_NOT_PROVIDED);
    }

    private function badgeIdNotValidProvided()
    {
        $this->setCode(InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidGetBadgeCommandExceptionCode::MESSAGE_CODE_BADGE_ID_NOT_VALID_PROVIDED);
    }

    private function userIdNotProvided()
    {
        $this->setCode(InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED)
             ->setMessage(InvalidGetBadgeCommandExceptionCode::MESSAGE_CODE_USER_ID_NOT_PROVIDED);
    }

    private function userIdNotValidProvided()
    {
        $this->setCode(InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidGetBadgeCommandExceptionCode::MESSAGE_CODE_USER_ID_NOT_VALID_PROVIDED);
    }
}
