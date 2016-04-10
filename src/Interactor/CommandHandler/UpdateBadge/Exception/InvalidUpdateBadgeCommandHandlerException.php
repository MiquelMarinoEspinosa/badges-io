<?php

namespace Interactor\CommandHandler\UpdateBadge\Exception;

use Interactor\Exception\BaseException;

class InvalidUpdateBadgeCommandHandlerException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED:
                $this->badgeNotUpdated();
                break;
            case InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND:
                $this->badgeNotFound();
                break;
            case InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN:
                $this->userNotValid();
                break;
            case InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND:
                $this->userNotFound();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidUpdateBadgeCommandHandlerException
     */
    private function badgeNotUpdated()
    {
        $this->setCode(InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED)
             ->setMessage(InvalidUpdateBadgeCommandHandlerExceptionCode::MESSAGE_CODE_BADGE_NOT_UPDATED);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandHandlerException
     */
    private function badgeNotFound()
    {
        $this->setCode(InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND)
             ->setMessage(InvalidUpdateBadgeCommandHandlerExceptionCode::MESSAGE_CODE_BADGE_NOT_FOUND);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandHandlerException
     */
    private function userNotValid()
    {
        $this->setCode(InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN)
             ->setMessage(InvalidUpdateBadgeCommandHandlerExceptionCode::MESSAGE_CODE_USER_FORBIDDEN);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandHandlerException
     */
    private function userNotFound()
    {
        $this->setCode(InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND)
             ->setMessage(InvalidUpdateBadgeCommandHandlerExceptionCode::MESSAGE_CODE_USER_NOT_FOUND);

        return $this;
    }
}
