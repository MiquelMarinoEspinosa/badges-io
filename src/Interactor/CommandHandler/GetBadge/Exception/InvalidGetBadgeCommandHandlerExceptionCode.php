<?php

namespace Interactor\CommandHandler\GetBadge\Exception;

class InvalidGetBadgeCommandHandlerExceptionCode
{
    const STATUS_CODE_BADGE_NOT_FOUND   = -1;
    const MESSAGE_CODE_BADGE_NOT_FOUND  = 'Badge Not Found';
    const STATUS_CODE_USER_FORBIDDEN    = -2;
    const MESSAGE_CODE_USER_FORBIDDEN   = 'User Not Valid';
}
