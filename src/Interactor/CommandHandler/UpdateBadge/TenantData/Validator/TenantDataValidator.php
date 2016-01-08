<?php

namespace Interactor\CommandHandler\UpdateBadge\TenantData\Validator;

use Interactor\CommandHandler\UpdateBadge\TenantData\Exception\InvalidTenantDataException;
use Interactor\CommandHandler\UpdateBadge\TenantData\Exception\InvalidTenantDataExceptionCode;
use Interactor\CommandHandler\UpdateBadge\TenantData\TenantData;
use Interactor\Validator\Validator;

class TenantDataValidator implements Validator
{
    /**
     * @var TenantData
     */
    private $tenantData;

    public function __construct(TenantData $tenantData)
    {
        $this->tenantData = $tenantData;
    }

    public function validate()
    {
        $this->validateId();
    }

    /**
     * @throws InvalidTenantDataException
     */
    private function validateId()
    {
        $this->checkIdIsNotNull()
             ->checkIdFormat();
    }

    /**
     * @return TenantDataValidator
     * @throws InvalidTenantDataException
     */
    private function checkIdIsNotNull()
    {
        $aNullId = null;
        if ($this->tenantData->id() === $aNullId) {
            throw $this->buildInvalidTenantDataException(InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_PROVIDED);
        }

        return $this;
    }

    /**
     * @return TenantDataValidator
     * @throws InvalidTenantDataException
     */
    private function checkIdFormat()
    {
        if ($this->noValidIdFormat($this->tenantData->id())) {
            throw $this->buildInvalidTenantDataException(
                InvalidTenantDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    private function noValidIdFormat($id)
    {
        return !is_string($id) || '' === trim($id);
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidTenantDataException
     */
    private function buildInvalidTenantDataException($statusCode)
    {
        return new InvalidTenantDataException($statusCode);
    }
}
