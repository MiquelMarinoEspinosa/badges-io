<?php

namespace Domain\Service;

interface IdGenerator
{
    /**
     * @return string
     */
    public function generateId();
}
