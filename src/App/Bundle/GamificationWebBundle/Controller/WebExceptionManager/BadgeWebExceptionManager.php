<?php

namespace App\Bundle\GamificationWebBundle\Controller\WebExceptionManager;

use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerException;

class BadgeWebExceptionManager
{
    public function applicationListBadgesExceptionBuildErrorMessage(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidListBadgesCommandException) {
            $message = "Some parameter is missing or some parameter/s format/s are wrong:" ;
        } elseif ($applicationException instanceof InvalidListBadgesCommandHandlerException) {
            $message = "Lista Badges Command Handler exception:";
        } else {
            $message = "Something went wrong :_(";
        }

        return [
            "webErrorMessage"   => $message,
            "exceptionMessage"  => $applicationException->getMessage()
        ] ;
    }
}
