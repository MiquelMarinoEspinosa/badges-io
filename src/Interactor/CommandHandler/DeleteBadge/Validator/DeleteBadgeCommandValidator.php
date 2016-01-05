<?php

namespace Interactor\CommandHandler\DeleteBadge\Validator;

use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandException;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandExceptionCode;
use Interactor\CommandHandler\DeleteBadge\DeleteBadgeCommand;
use Interactor\Validator\Validator;

class DeleteBadgeCommandValidator implements Validator
{
    /**
     * @var DeleteBadgeCommand
     */
    private $deleteBadgeCommand;

    public function __construct(DeleteBadgeCommand $deleteBadgeCommand)
    {
        $this->deleteBadgeCommand = $deleteBadgeCommand;
    }

    public function validate()
    {
        $this->validateBadgeId()
             ->validateTenantId();
    }

    /**
     * @return DeleteBadgeCommandValidator
     * @throws InvalidDeleteBadgeCommandException
     */
    private function validateBadgeId()
    {
        $this->checkBadgeIdNotNull()
             ->checkBadgeIdFormat();

        return $this;
    }

    /**
     * @return DeleteBadgeCommandValidator
     * @throws InvalidDeleteBadgeCommandException
     */
    private function checkBadgeIdNotNull()
    {
        $aNullId = null;
        if ($this->deleteBadgeCommand->badgeId() === $aNullId) {
            throw $this->buildInvalidDeleteCommandException(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return DeleteBadgeCommandValidator
     * @throws InvalidDeleteBadgeCommandException
     */
    private function checkBadgeIdFormat()
    {
        if ($this->notValidBadgeIdFormat($this->deleteBadgeCommand->badgeId())) {
            throw $this->buildInvalidDeleteCommandException(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $badgeId
     *
     * @return bool
     */
    private function notValidBadgeIdFormat($badgeId)
    {
        return !is_string($badgeId) || '' === trim($badgeId);
    }

    /**
     * @return DeleteBadgeCommandValidator
     * @throws InvalidDeleteBadgeCommandException
     */
    private function validateTenantId()
    {
        $this->checkTenantIdNotNull()
             ->checkTenantIdFormat();

        return $this;
    }

    /**
     * @return DeleteBadgeCommandValidator
     * @throws InvalidDeleteBadgeCommandException
     */
    private function checkTenantIdNotNull()
    {
        $aNullId = null;
        if ($this->deleteBadgeCommand->tenantId() === $aNullId) {
            throw $this->buildInvalidDeleteCommandException(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return DeleteBadgeCommandValidator
     * @throws InvalidDeleteBadgeCommandException
     */
    private function checkTenantIdFormat()
    {
        if ($this->notValidTenantIdFormat($this->deleteBadgeCommand->tenantId())) {
            throw $this->buildInvalidDeleteCommandException(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED
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
     * @return InvalidDeleteBadgeCommandException
     */
    private function buildInvalidDeleteCommandException($statusCode)
    {
        return new InvalidDeleteBadgeCommandException($statusCode);
    }
}
