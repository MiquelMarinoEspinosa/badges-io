<?php

namespace Interactor\CommandHandler\DeleteBadge\Exception;

use Domain\Exception\BaseException;

class InvalidDeleteBadgeCommandHandlerException extends BaseException
{
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND:
                $this->badgeNotFound();
                break;
            case InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN:
                $this->tenantNotValid();
                break;
            case InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED:
                $this->badgeNotRemoved();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidDeleteBadgeCommandHandlerException
     */
    private function badgeNotFound()
    {
        return $this->setCode(InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND)
                    ->setMessage(InvalidDeleteBadgeCommandHandlerExceptionCode::MESSAGE_CODE_BADGE_NOT_FOUND);
    }

    /**
     * @return InvalidDeleteBadgeCommandHandlerException
     */
    private function tenantNotValid()
    {
        return $this->setCode(InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN)
                    ->setMessage(InvalidDeleteBadgeCommandHandlerExceptionCode::MESSAGE_CODE_TENANT_FORBIDDEN);
    }

    /**
     * @return InvalidDeleteBadgeCommandHandlerException
     */
    private function badgeNotRemoved()
    {
        return $this->setCode(InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED)
                    ->setMessage(InvalidDeleteBadgeCommandHandlerExceptionCode::MESSAGE_CODE_BADGE_NOT_REMOVED);
    }
}
