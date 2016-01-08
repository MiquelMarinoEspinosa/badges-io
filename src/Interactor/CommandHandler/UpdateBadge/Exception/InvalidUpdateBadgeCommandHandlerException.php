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
            case InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN:
                $this->tenantNotValid();
                break;
            case InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND:
                $this->tenantNotFound();
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
    private function tenantNotValid()
    {
        $this->setCode(InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN)
             ->setMessage(InvalidUpdateBadgeCommandHandlerExceptionCode::MESSAGE_CODE_TENANT_FORBIDDEN);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandHandlerException
     */
    private function tenantNotFound()
    {
        $this->setCode(InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND)
             ->setMessage(InvalidUpdateBadgeCommandHandlerExceptionCode::MESSAGE_CODE_TENANT_NOT_FOUND);

        return $this;
    }
}
