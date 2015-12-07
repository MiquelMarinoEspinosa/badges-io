<?php

namespace Domain\Badge\Exception;

use Exception\BaseException;

class InvalidBadgeException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_PROVIDED:
                $this->idNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED:
                $this->idNotValidProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED:
                $this->nameNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED:
                $this->nameNotValidProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED:
                $this->descriptionNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED:
                $this->descriptionNotValidProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED:
                $this->isMultiTenantNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED:
                $this->isMultiTenantNotValidProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_PROVIDED:
                $this->tenantsNotProvided();
                break;
            case InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_VALID_PROVIDED:
                $this->tenantsNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidBadgeException
     */
    private function idNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function idNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function nameNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_NAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function nameNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_NAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function descriptionNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_DESCRIPTION_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function descriptionNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_DESCRIPTION_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function isMultiTenantNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_IS_MULTI_TENANT_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function isMultiTenantNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function tenantsNotProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_TENANTS_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidBadgeException
     */
    private function tenantsNotValidProvided()
    {
        $this->setCode(InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_VALID_PROVIDED)
             ->setMessage(InvalidBadgeExceptionCode::MESSAGE_CODE_TENANTS_NOT_VALID_PROVIDED);

        return $this;
    }
}
