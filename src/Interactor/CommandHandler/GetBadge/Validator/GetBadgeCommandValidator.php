<?php

namespace Interactor\CommandHandler\GetBadge\Validator;

use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandException;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandExceptionCode;
use Interactor\CommandHandler\GetBadge\GetBadgeCommand;
use Interactor\Validator\Validator;

class GetBadgeCommandValidator implements Validator
{
    /**
     * @var GetBadgeCommand
     */
    private $getBadgeCommand;

    public function __construct(GetBadgeCommand $getBadgeCommand)
    {
        $this->getBadgeCommand = $getBadgeCommand;
    }

    public function validate()
    {
        $this->validateBadgeId()
             ->validateUserId();
    }

    /**
     * @return GetBadgeCommandValidator
     * @throws InvalidGetBadgeCommandException
     */
    private function validateBadgeId()
    {
        $this->checkBadgeIdNotNull()
              ->checkBadgeIdFormat();

        return $this;
    }

    /**
     * @return GetBadgeCommandValidator
     * @throws InvalidGetBadgeCommandException
     */
    private function checkBadgeIdNotNull()
    {
        $aNullId = null;
        if ($this->getBadgeCommand->badgeId() === $aNullId) {
            throw $this->buildInvalidGetCommandException(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return GetBadgeCommandValidator
     * @throws InvalidGetBadgeCommandException
     */
    private function checkBadgeIdFormat()
    {
        if ($this->notValidBadgeIdFormat($this->getBadgeCommand->badgeId())) {
            throw $this->buildInvalidGetCommandException(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED
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
     * @return GetBadgeCommandValidator
     * @throws InvalidGetBadgeCommandException
     */
    private function validateUserId()
    {
        $this->checkUserIdNotNull()
            ->checkUserIdFormat();

        return $this;
    }

    /**
     * @return GetBadgeCommandValidator
     * @throws InvalidGetBadgeCommandException
     */
    private function checkUserIdNotNull()
    {
        $aNullId = null;
        if ($this->getBadgeCommand->userId() === $aNullId) {
            throw $this->buildInvalidGetCommandException(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return GetBadgeCommandValidator
     * @throws InvalidGetBadgeCommandException
     */
    private function checkUserIdFormat()
    {
        if ($this->notValidUserIdFormat($this->getBadgeCommand->userId())) {
            throw $this->buildInvalidGetCommandException(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED
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
     * @return InvalidGetBadgeCommandException
     */
    private function buildInvalidGetCommandException($statusCode)
    {
        return new InvalidGetBadgeCommandException($statusCode);
    }
}
