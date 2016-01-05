<?php

namespace Interactor\CommandHandler\GetBadge;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\GetBadge\Validator\GetBadgeCommandValidator;

class GetBadgeCommand extends BaseCommand
{
    /** @var string */
    private $badgeId;

    /** @var string */
    private $tenantId;

    /**
     * @param string $badgeId
     * @param string $tenantId
     */
    public function __construct($badgeId, $tenantId)
    {
        $this->setBadgeId($badgeId)
             ->setTenantId($tenantId)
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
    public function tenantId()
    {
        return $this->tenantId;
    }

    /**
     * @param string $tenantId
     *
     * @return GetBadgeCommand
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
        return new GetBadgeCommandValidator($this);
    }
}
