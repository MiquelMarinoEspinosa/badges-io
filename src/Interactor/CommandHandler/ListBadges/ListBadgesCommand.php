<?php

namespace Interactor\CommandHandler\ListBadges;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\ListBadges\Validator\ListBadgesCommandValidator;

class ListBadgesCommand extends BaseCommand
{
    /** @var string */
    private $userId;

    /**
     * @param string $userId
     */
    public function __construct($userId)
    {
        $this->setUserId($userId)
             ->validate();
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
     * @return ListBadgesCommand
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
        return new ListBadgesCommandValidator($this);
    }
}
