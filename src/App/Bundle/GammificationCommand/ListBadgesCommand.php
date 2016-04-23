<?php

namespace App\Bundle\GammificationCommand;

use App\Bundle\GammificationCommand\CommandExceptionManager\BadgeCommandExceptionManager;
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
    const LEFT_BLANK     = '     ';
    const TEXT_DELIMITER =
        self::LEFT_BLANK . '|----------------------------------------------------------------------------|';
    const IS_MULTI_USER = 1;

    protected function configure()
    {
        $this
            ->setName('gamification:list-badges')
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
        try {
            $listBadgesCommand = $this->buildListBadgesCommandByRequest($input->getArgument('userId'));

            $badgesResources = $this->getContainer()->get(
                "gamification.interactor.command_handler.list_badges.list_badges_command_handler"
            )->handle($listBadgesCommand);

            $this->showCommandResult($output, $input->getArgument('userId'), $badgesResources);
        } catch (\Exception $exception) {
            $this->buildCommandExceptionManager()
                 ->applicationListBadgesExceptionShowCommandError($output, $exception);
        }
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
     * @param OutputInterface $output
     * @param string $userId
     * @param BadgeResource $badgesResources
     */
    private function showCommandResult(OutputInterface $output, $userId, $badgesResources)
    {
        $this->showCommandTitleResult($output, $userId);
        foreach ($badgesResources as $badgeResource) {
            $this->showBadgeResourceFields($output, $badgeResource, $userId);
        }
    }

    /**
     * @param OutputInterface $output
     * @param string $userId
     */
    private function showCommandTitleResult(OutputInterface $output, $userId)
    {
        $title = static::LEFT_BLANK . "|        <info>BADGES LIST BY USER ID $userId </info>        |";

        $output->writeln(static::TEXT_DELIMITER);
        $output->writeln($title);
        $output->writeln(static::TEXT_DELIMITER);
    }

    /**
     * @param OutputInterface $output
     * @param BadgeResource $badgeResource
     * @param string $userId
     */
    private function showBadgeResourceFields(OutputInterface $output, BadgeResource $badgeResource, $userId)
    {
        $isMultiUser = ($badgeResource->isMultiUser() == static::IS_MULTI_USER) ? 'Yes' : 'No';
        $output->writeln(static::LEFT_BLANK . '|name:        ' . $badgeResource->name() .
            $this->computeBlankSizeByStringLength(strlen($badgeResource->name())) . '|');
        $output->writeln(static::LEFT_BLANK . '|description: ' . $badgeResource->description() .
            $this->computeBlankSizeByStringLength(strlen($badgeResource->description())) . '|');
        $output->writeln(static::LEFT_BLANK . '|isMultiUser: ' . $isMultiUser .
            $this->computeBlankSizeByStringLength(strlen($isMultiUser)) .'|');
        $output->writeln(static::LEFT_BLANK . '|image href:  ' . $badgeResource->imageResource()->href() .
            $this->computeBlankSizeByStringLength(strlen($badgeResource->imageResource()->href())) . '|');
        $output->writeln(static::TEXT_DELIMITER);
    }

    /**
     * @param int $elemSize
     *
     * @return string
     */
    private function computeBlankSizeByStringLength($elemSize)
    {
        $blankString = '';
        for ($blankSize = 0; $blankSize <  static::MAX_BLANK_SIZE - $elemSize; $blankSize++) {
            $blankString .= ' ';
        }

        return $blankString;
    }

    /**
     * @return BadgeCommandExceptionManager
     */
    private function buildCommandExceptionManager()
    {
        return $this->getContainer()->get(
            "gamification.app.bundle.gammification_command.command_exception_manager.badge_command_exception_manager"
        );
    }
}
