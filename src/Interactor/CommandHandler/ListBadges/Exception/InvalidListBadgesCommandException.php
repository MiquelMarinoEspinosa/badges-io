<?php

namespace Interactor\CommandHandler\ListBadges\Exception;

use Interactor\Exception\BaseException;

class InvalidListBadgesCommandException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED:
                $this->userIdNotProvided();
                break;
            case InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED:
                $this->userIdNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidListBadgesCommandException
     */
    private function userIdNotProvided()
    {
        return $this->setCode(InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED)
                    ->setMessage(InvalidListBadgesCommandExceptionCode::MESSAGE_CODE_USER_ID_NOT_PROVIDED);
    }

    /**
     * @return InvalidListBadgesCommandException
     */
    private function userIdNotValidProvided()
    {
        return $this->setCode(InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED)
                    ->setMessage(InvalidListBadgesCommandExceptionCode::MESSAGE_CODE_USER_ID_NOT_VALID_PROVIDED);
    }
}
