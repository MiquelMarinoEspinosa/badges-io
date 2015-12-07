<?php

namespace Interactor\CommandHandler;

interface CommandHandler
{
    /**
     * @param Command $command
     *
     * @return mixed
     */
    public function handle($command);
}
