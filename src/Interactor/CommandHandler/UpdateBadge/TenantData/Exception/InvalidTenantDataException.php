<?php

namespace Interactor\CommandHandler\UpdateBadge\TenantData\Exception;

use Interactor\Exception\BaseException;

class InvalidTenantDataException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_PROVIDED:
                $this->idNotProvided();
                break;
            case InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED:
                $this->idNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidTenantDataException
     */
    private function idNotProvided()
    {
        $this->setCode(InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_PROVIDED)
             ->setMessage(InvalidTenantDataExceptionCode::MESSAGE_CODE_ID_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidTenantDataException
     */
    private function idNotValidProvided()
    {
        $this->setCode(InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED)
            ->setMessage(InvalidTenantDataExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }
}
