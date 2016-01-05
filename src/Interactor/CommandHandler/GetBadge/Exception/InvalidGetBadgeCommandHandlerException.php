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
            case InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_VALID:
                $this->tenantNotValid();
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
    private function tenantNotValid()
    {
        return $this->setCode(InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_VALID)
                    ->setMessage(InvalidGetBadgeCommandHandlerExceptionCode::MESSAGE_CODE_TENANT_NOT_VALID);
    }
}