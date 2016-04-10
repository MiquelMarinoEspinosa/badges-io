<?php

namespace Interactor\CommandHandler\DeleteBadge;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\DeleteBadge\Validator\DeleteBadgeCommandValidator;

class DeleteBadgeCommand extends BaseCommand
{
    /** @var string */
    private $badgeId;
    /** @var string */
    private $userId;

    /**
     * @param string $badgeId
     * @param string $userId
     */
    public function __construct($badgeId, $userId)
    {
        $this->setBadgeId($badgeId)
             ->setUserId($userId)
             ->validate();
    }

    /**
     * @return string
     */
    public function badgeId()
    {
        return $this->badgeId;
    }

    /**
     * @param string $badgeId
     *
     * @return DeleteBadgeCommand
     */
    private function setBadgeId($badgeId)
    {
        $this->badgeId = $badgeId;

        return $this;
    }

    /**
     * @return string
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     *
     * @return DeleteBadgeCommand
     */
    private function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function buildValidator()
    {
        return new DeleteBadgeCommandValidator($this);
    }
}
