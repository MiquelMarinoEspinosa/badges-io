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
            case InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_PROVIDED:
                $this->tenantIdNotProvided();
                break;
            case InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED:
                $this->tenantIdNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidListBadgesCommandException
     */
    private function tenantIdNotProvided()
    {
        return $this->setCode(InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_PROVIDED)
                    ->setMessage(InvalidListBadgesCommandExceptionCode::MESSAGE_CODE_TENANT_ID_NOT_PROVIDED);
    }

    /**
     * @return InvalidListBadgesCommandException
     */
    private function tenantIdNotValidProvided()
    {
        return $this->setCode(InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED)
                    ->setMessage(InvalidListBadgesCommandExceptionCode::MESSAGE_CODE_TENANT_ID_NOT_VALID_PROVIDED);
    }
}
