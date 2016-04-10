<?php

namespace Interactor\CommandHandler\GetBadge;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\GetBadge\Validator\GetBadgeCommandValidator;

class GetBadgeCommand extends BaseCommand
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
     * @return GetBadgeCommand
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
     * @return GetBadgeCommand
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
        return new GetBadgeCommandValidator($this);
    }
}
