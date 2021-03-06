<?php

namespace Interactor\CommandHandler\DeleteBadge\Exception;

class InvalidDeleteBadgeCommandHandlerExceptionCode
{
    const STATUS_CODE_BADGE_NOT_FOUND    = -1;
    const MESSAGE_CODE_BADGE_NOT_FOUND   = 'Badge Not Found';
    const STATUS_CODE_USER_FORBIDDEN     = -2;
    const MESSAGE_CODE_USER_FORBIDDEN    = 'User Forbidden';
    const STATUS_CODE_BADGE_NOT_REMOVED  = -3;
    const MESSAGE_CODE_BADGE_NOT_REMOVED = 'Badge Not Removed';
}
