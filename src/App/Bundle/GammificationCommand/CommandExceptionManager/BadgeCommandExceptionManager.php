<?php

namespace App\Bundle\GammificationCommand\CommandExceptionManager;

use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerException;
use Symfony\Component\Console\Output\OutputInterface;

class BadgeCommandExceptionManager
{
    const MAX_BLANK_SIZE = 66;
    const LEFT_DELIMITER = "|     ";
    const LEFT_BLANK     = '     ';
    const TEXT_DELIMITER =
        self::LEFT_BLANK . '|-----------------------------------------------------------------------|';

    /**
     * @param OutputInterface $output
     * @param \Exception $applicationException
     */
    public function applicationListBadgesExceptionShowCommandError(
        OutputInterface $output,
        \Exception $applicationException
    ) {
        if ($applicationException instanceof InvalidListBadgesCommandException) {
            $message = "Some parameter is missing or some parameter/s format/s are wrong:" ;
            $errorMessage = $this->applyFormatToMessage($message) . "|\n";
        } elseif ($applicationException instanceof InvalidListBadgesCommandHandlerException) {
            $message = "Lista Badges Command Handler exception:";
            $errorMessage = $this->applyFormatToMessage($message) ."|\n";
        } else {
            $message = "Something went worng :_(";
            $errorMessage = $this->applyFormatToMessage($message) ."|\n";

        }

        $errorMessage .= $this->applyFormatToMessage($applicationException->getMessage()) . "|";
        $this->showCommandErrorMessage($output, $errorMessage);
    }

    /**
     * @param OutputInterface $output
     * @param string $errorMessage
     */
    private function showCommandErrorMessage(OutputInterface $output, $errorMessage)
    {
        $output->writeln("<error>" . static::TEXT_DELIMITER);
        $listBadgesCommandError = "LIST BADGES COMMAND ERROR";
        $generalErrorMessage = $this->applyFormatToMessage($listBadgesCommandError) . "|\n";
        $generalErrorMessage .= $errorMessage;
        $output->writeln($generalErrorMessage);
        $output->writeln(static::TEXT_DELIMITER . "</error>");
    }

    /**
     * @param string $message
     *
     * @return string
     */
    private function applyFormatToMessage($message)
    {
        return static::LEFT_BLANK . static::LEFT_DELIMITER .
        $message .
        $this->computeBlankSizeByStringLength(strlen($message));
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
}
