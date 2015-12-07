<?php

namespace Test\Domain\Service;

use Domain\Service\IdGenerator;

class FakeIdGenerator implements IdGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateId()
    {
        return '34214214';
    }
}
