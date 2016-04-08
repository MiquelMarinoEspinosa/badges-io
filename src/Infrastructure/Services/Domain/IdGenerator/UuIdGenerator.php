<?php

namespace Infrastructure\Services\Domain\IdGenerator;

use Domain\Service\IdGenerator;
use Rhumsaa\Uuid\Uuid;

class UuIdGenerator implements IdGenerator
{
    /**
     * @var Uuid
     */
    private $uuid;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    /**
     * {@inheritdoc}
     */
    public function generateId()
    {
        return $this->uuid->toString();
    }
}
