<?php

namespace Interactor\CommandHandler\ListBadges\Exception;

use Domain\Exception\BaseException;

class InvalidListBadgesCommandHandlerException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND:
                $this->badgeNotFound();
                break;
            case InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND:
                $this->tenantNotFound();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidListBadgesCommandHandlerException
     */
    private function badgeNotFound()
    {
        return $this->setCode(InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND)
                    ->setMessage(InvalidListBadgesCommandHandlerExceptionCode::MESSAGE_CODE_BADGE_NOT_FOUND);
    }

    /**
     * @return BaseException
     */
    private function tenantNotFound()
    {
        return $this->setCode(InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_TENANT_NOT_FOUND)
                    ->setMessage(InvalidListBadgesCommandHandlerExceptionCode::MESSAGE_CODE_TENANT_NOT_FOUND);
    }
}
