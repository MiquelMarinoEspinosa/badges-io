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
        $this->validateUserId();
    }

    /**
     * @return ListBadgesCommandValidator
     * @throws InvalidListBadgesCommandException
     */
    private function validateUserId()
    {
        $this->checkUserIdNotNull()
             ->checkUserIdFormat();

        return $this;
    }

    /**
     * @return ListBadgesCommandValidator
     * @throws InvalidListBadgesCommandException
     */
    private function checkUserIdNotNull()
    {
        $aNullId = null;
        if ($this->listBadgesCommand->userId() === $aNullId) {
            throw $this->buildInvalidGetCommandException(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return ListBadgesCommandValidator
     * @throws InvalidListBadgesCommandException
     */
    private function checkUserIdFormat()
    {
        if ($this->notValidUserIdFormat($this->listBadgesCommand->userId())) {
            throw $this->buildInvalidGetCommandException(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED
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
     * @return InvalidListBadgesCommandException
     */
    private function buildInvalidGetCommandException($statusCode)
    {
        return new InvalidListBadgesCommandException($statusCode);
    }
}
