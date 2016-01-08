<?php

namespace Interactor\CommandHandler\UpdateBadge\Exception;

use Interactor\Exception\BaseException;

class InvalidUpdateBadgeCommandException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_ID_NOT_PROVIDED:
                $this->idNotProvided();
                break;
            case InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED:
                $this->idNotValidProvided();
                break;
            case InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED:
                $this->nameNotProvided();
                break;
            case InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED:
                $this->nameNotValidProvided();
                break;
            case InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED:
                $this->descriptionNotProvided();
                break;
            case InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED:
                $this->descriptionNotValidProvided();
                break;
            case InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED:
                $this->isMultiTenantNotProvided();
                break;
            case InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED:
                $this->isMultiTenantNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidUpdateBadgeCommandException
     */
    private function idNotProvided()
    {
        $this->setCode(InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_ID_NOT_PROVIDED)
             ->setMessage(InvalidUpdateBadgeCommandExceptionCode::MESSAGE_CODE_ID_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandException
     */
    private function idNotValidProvided()
    {
        $this->setCode(InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidUpdateBadgeCommandExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandException
     */
    private function nameNotProvided()
    {
        $this->setCode(InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED)
             ->setMessage(InvalidUpdateBadgeCommandExceptionCode::MESSAGE_CODE_NAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandException
     */
    private function nameNotValidProvided()
    {
        $this->setCode(InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidUpdateBadgeCommandExceptionCode::MESSAGE_CODE_NAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandException
     */
    private function descriptionNotProvided()
    {
        $this->setCode(InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED)
             ->setMessage(InvalidUpdateBadgeCommandExceptionCode::MESSAGE_CODE_DESCRIPTION_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandException
     */
    private function descriptionNotValidProvided()
    {
        $this->setCode(InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED)
            ->setMessage(InvalidUpdateBadgeCommandExceptionCode::MESSAGE_CODE_DESCRIPTION_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandException
     */
    private function isMultiTenantNotProvided()
    {
        $this->setCode(InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED)
             ->setMessage(InvalidUpdateBadgeCommandExceptionCode::MESSAGE_CODE_IS_MULTI_TENANT_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUpdateBadgeCommandException
     */
    private function isMultiTenantNotValidProvided()
    {
        $this->setCode(InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED)
             ->setMessage(InvalidUpdateBadgeCommandExceptionCode::MESSAGE_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED);

        return $this;
    }
}
