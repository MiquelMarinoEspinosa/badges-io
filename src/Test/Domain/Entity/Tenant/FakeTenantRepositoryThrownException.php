<?php

namespace Test\Domain\Entity\Tenant;

use Infrastructure\InMemory\Domain\Entity\Tenant\InMemoryTenantRepository;

class FakeTenantRepositoryThrownException extends InMemoryTenantRepository
{
    const FIND_THROW_EXCEPTION = -1;

    /**
     * @var int
     */
    private $methodException;

    public function __construct($tenants, $methodException)
    {
        $this->methodException = $methodException;
        parent::__construct($tenants);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $this->checkIfHasToThrownAnException(static::FIND_THROW_EXCEPTION);
        parent::find($id);
    }

    /**
     * @param int $methodException
     *
     * @throws \Exception
     */
    private function checkIfHasToThrownAnException($methodException)
    {
        if ($this->methodException === $methodException) {
            throw new \Exception();
        }
    }
}
