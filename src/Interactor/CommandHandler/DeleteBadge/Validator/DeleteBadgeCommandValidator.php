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
             ->validateUserId();
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
    private function validateUserId()
    {
        $this->checkUserIdNotNull()
             ->checkUserIdFormat();

        return $this;
    }

    /**
     * @return DeleteBadgeCommandValidator
     * @throws InvalidDeleteBadgeCommandException
     */
    private function checkUserIdNotNull()
    {
        $aNullId = null;
        if ($this->deleteBadgeCommand->userId() === $aNullId) {
            throw $this->buildInvalidDeleteCommandException(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return DeleteBadgeCommandValidator
     * @throws InvalidDeleteBadgeCommandException
     */
    private function checkUserIdFormat()
    {
        if ($this->notValidUserIdFormat($this->deleteBadgeCommand->userId())) {
            throw $this->buildInvalidDeleteCommandException(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $userId
     *
     * @return bool
     */
    private function notValidUserIdFormat($userId)
    {
        return !is_string($userId) || '' === trim($userId);
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
