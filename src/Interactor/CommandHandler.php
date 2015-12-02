<?php

namespace Interactor;

interface CommandHandler
{
    /**
     * @param Command $command
     *
     * @return mixed
     */
    public function handle($command);
}
