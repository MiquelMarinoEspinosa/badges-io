<?php

namespace Interactor\CommandHandler\ListBadges\Validator;

use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandExceptionCode;
use Interactor\CommandHandler\ListBadges\ListBadgesCommand;
use Interactor\Validator\Validator;

class ListBadgesCommandValidator implements Validator
{
    /**
     * @var ListBadgesCommand
     */
    private $listBadgesCommand;

    public function __construct(ListBadgesCommand $listBadgesCommand)
    {
        $this->listBadgesCommand = $listBadgesCommand;
    }

    public function validate()
    {
        $this->validateTenantId();
    }

    /**
     * @return ListBadgesCommandValidator
     * @throws InvalidListBadgesCommandException
     */
    private function validateTenantId()
    {
        $this->checkTenantIdNotNull()
             ->checkTenantIdFormat();

        return $this;
    }

    /**
     * @return ListBadgesCommandValidator
     * @throws InvalidListBadgesCommandException
     */
    private function checkTenantIdNotNull()
    {
        $aNullId = null;
        if ($this->listBadgesCommand->tenantId() === $aNullId) {
            throw $this->buildInvalidGetCommandException(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ListBadgesCommandValidator
     * @throws InvalidListBadgesCommandException
     */
    private function checkTenantIdFormat()
    {
        if ($this->notValidTenantIdFormat($this->listBadgesCommand->tenantId())) {
            throw $this->buildInvalidGetCommandException(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $tenantId
     *
     * @return bool
     */
    private function notValidTenantIdFormat($tenantId)
    {
        return !is_string($tenantId) || '' === trim($tenantId);
    }


    /**
     * @param int $statusCode
     *
     * @return InvalidListBadgesCommandException
     */
    private function buildInvalidGetCommandException($statusCode)
    {
        return new InvalidListBadgesCommandException($statusCode);
    }
}
