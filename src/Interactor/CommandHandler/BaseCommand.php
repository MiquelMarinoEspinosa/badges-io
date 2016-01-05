<?php

namespace Interactor\CommandHandler;

use Interactor\Validator\Validator;

abstract class BaseCommand implements Command
{
    /**
     * @return BaseCommand
     */
    protected function validate()
    {
        $this->buildValidator()->validate();

        return $this;
    }

    /**
     * @return Validator
     */
    abstract protected function buildValidator();
}
