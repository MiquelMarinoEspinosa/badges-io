<?php

namespace App\Command\GammificationCommand;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListBadgesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('gamification:list_badges')
            ->setDescription('List multiUser badges and badges owned by the user given a userId')
            ->addArgument(
                'user_id',
                InputArgument::REQUIRED,
                'The user id to list her / his badges and multiUser badges'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('ola k ase');
    }
}
