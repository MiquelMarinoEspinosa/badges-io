<?php

namespace Interactor\CommandHandler\GetBadge\Exception;

use Domain\Exception\BaseException;

class InvalidGetBadgeCommandHandlerException extends BaseException
{
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND:
                $this->badgeNotFound();
                break;
            case InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN:
                $this->userNotValid();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidGetBadgeCommandHandlerException
     */
    private function badgeNotFound()
    {
        return $this->setCode(InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND)
                    ->setMessage(InvalidGetBadgeCommandHandlerExceptionCode::MESSAGE_CODE_BADGE_NOT_FOUND);
    }

    /**
     * @return BaseException
     */
    private function userNotValid()
    {
        return $this->setCode(InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN)
                    ->setMessage(InvalidGetBadgeCommandHandlerExceptionCode::MESSAGE_CODE_USER_FORBIDDEN);
    }
}
