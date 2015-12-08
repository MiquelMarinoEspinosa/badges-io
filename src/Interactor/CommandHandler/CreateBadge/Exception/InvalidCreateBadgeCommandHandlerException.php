<?php

namespace Interactor\CommandHandler\CreateBadge\Exception;

use Interactor\Exception\BaseException;

class InvalidCreateBadgeCommandHandlerException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED:
                $this->badgeNotCreated();
                break;
            case InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND:
                $this->tenantNotFound();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidCreateBadgeCommandHandlerException
     */
    private function badgeNotCreated()
    {
        $this->setCode(InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED)
             ->setMessage(InvalidCreateBadgeCommandHandlerExceptionCode::MESSAGE_CODE_BADGE_NOT_CREATED);

        return $this;
    }

    /**
     * @return InvalidCreateBadgeCommandHandlerException
     */
    private function tenantNotFound()
    {
        $this->setCode(InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND)
             ->setMessage(InvalidCreateBadgeCommandHandlerExceptionCode::MESSAGE_CODE_TENANT_NOT_FOUND);

        return $this;
    }
}
