<?php

namespace Interactor\CommandHandler\ListBadges;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\ListBadges\Validator\ListBadgesCommandValidator;

class ListBadgesCommand extends BaseCommand
{
    /** @var string */
    private $tenantId;

    /**
     * @param string $tenantId
     */
    public function __construct($tenantId)
    {
        $this->setTenantId($tenantId)
             ->validate();
    }

    /**
     * @return string
     */
    public function tenantId()
    {
        return $this->tenantId;
    }

    /**
     * @param string $tenantId
     *
     * @return ListBadgesCommand
     */
    private function setTenantId($tenantId)
    {
        $this->tenantId = $tenantId;

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
