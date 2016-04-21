<?php

namespace App\Bundle\GammificationCommand;

use Infrastructure\Resource\Domain\Entity\Badge\BadgeResource;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Interactor\CommandHandler\ListBadges\ListBadgesCommand as InteractorListBadgesCommand;

class ListBadgesCommand extends ContainerAwareCommand
{
    const MAX_BLANK_SIZE = 63;

    protected function configure()
    {
        $this
            ->setName('gamification:list_badges')
            ->setDescription('List multiUser badges and badges owned by the user given a userId')
            ->addArgument(
                'userId',
                InputArgument::REQUIRED,
                'The user id to list her / his badges and multiUser badges'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $listBadgesCommand = $this->buildListBadgesCommandByRequest($input->getArgument('userId'));

        $badgesResources = $this->getContainer()->get(
            "gamification.interactor.command_handler.list_badges.list_badges_command_handler"
        )->handle($listBadgesCommand);

        $this->showCommandResult($input->getArgument('userId'), $output, $badgesResources);
    }

    /**
     * @param string $userId
     *
     * @return ListBadgesCommand
     */
    private function buildListBadgesCommandByRequest($userId)
    {
        return new InteractorListBadgesCommand($userId);
    }

    /**
     * @param string $userId
     * @param OutputInterface $output
     * @param BadgeResource $badgesResources
     */
    private function showCommandResult($userId, OutputInterface $output, $badgesResources)
    {
        $output->writeln("     |----------------------------------------------------------------------------|");
        $output->writeln("     |        <info>BADGES LIST BY USER ID $userId </info>        |");
        $output->writeln("     |----------------------------------------------------------------------------|");
        foreach ($badgesResources as $badgeResource) {
            $this->showBadgeResourceFields($output, $badgeResource, $userId);
        }
    }

    /**
     * @param OutputInterface $output
     * @param BadgeResource $badgeResource
     * @param string $userId
     */
    private function showBadgeResourceFields(OutputInterface $output, BadgeResource $badgeResource, $userId)
    {
        $isMultiUser = ($badgeResource->isMultiUser() == 1) ? 'Yes' : 'No';
        $output->writeln('     |name:        ' . $badgeResource->name() .
            $this->computeBlankSizeByStringLength(strlen($badgeResource->name())) . "|");
        $output->writeln('     |description: ' . $badgeResource->description() .
            $this->computeBlankSizeByStringLength(strlen($badgeResource->description())) . "|");
        $output->writeln('     |image href:  ' . $badgeResource->imageResource()->href() .
            $this->computeBlankSizeByStringLength(strlen($badgeResource->imageResource()->href())) . "|");
        $output->writeln('     |isMultiuser: ' . $isMultiUser .
            $this->computeBlankSizeByStringLength(strlen($isMultiUser)) ."|");
        $output->writeln("     |----------------------------------------------------------------------------|");
    }

    /**
     * @param int $elemSize
     *
     * @return string
     */
    private function computeBlankSizeByStringLength($elemSize)
    {
        $blankString = '';
        for ($blankSize = 0; $blankSize <  self::MAX_BLANK_SIZE - $elemSize; $blankSize++) {
            $blankString .= ' ';
        }

        return $blankString;
    }
}
