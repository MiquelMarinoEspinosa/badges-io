<?php

namespace Interactor\CommandHandler\CreateBadge\Exception;

use Interactor\Exception\BaseException;

class InvalidCreateBadgeCommandException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED:
                $this->nameNotProvided();
                break;
            case InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED:
                $this->nameNotValidProvided();
                break;
            case InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED:
                $this->descriptionNotProvided();
                break;
            case InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED:
                $this->descriptionNotValidProvided();
                break;
            case InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED:
                $this->isMultiTenantNotProvided();
                break;
            case InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED:
                $this->isMultiTenantNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidCreateBadgeCommandException
     */
    private function nameNotProvided()
    {
        $this->setCode(InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED)
             ->setMessage(InvalidCreateBadgeCommandExceptionCode::MESSAGE_CODE_NAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidCreateBadgeCommandException
     */
    private function nameNotValidProvided()
    {
        $this->setCode(InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidCreateBadgeCommandExceptionCode::MESSAGE_CODE_NAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidCreateBadgeCommandException
     */
    private function descriptionNotProvided()
    {
        $this->setCode(InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED)
             ->setMessage(InvalidCreateBadgeCommandExceptionCode::MESSAGE_CODE_DESCRIPTION_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidCreateBadgeCommandException
     */
    private function descriptionNotValidProvided()
    {
        $this->setCode(InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED)
            ->setMessage(InvalidCreateBadgeCommandExceptionCode::MESSAGE_CODE_DESCRIPTION_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidCreateBadgeCommandException
     */
    private function isMultiTenantNotProvided()
    {
        $this->setCode(InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED)
             ->setMessage(InvalidCreateBadgeCommandExceptionCode::MESSAGE_CODE_IS_MULTI_TENANT_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidCreateBadgeCommandException
     */
    private function isMultiTenantNotValidProvided()
    {
        $this->setCode(InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED)
             ->setMessage(InvalidCreateBadgeCommandExceptionCode::MESSAGE_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED);

        return $this;
    }
}
