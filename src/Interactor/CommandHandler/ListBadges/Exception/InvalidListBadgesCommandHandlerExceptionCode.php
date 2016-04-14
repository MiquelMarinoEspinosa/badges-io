<?php

namespace Interactor\CommandHandler\ListBadges\Exception;

class InvalidListBadgesCommandHandlerExceptionCode
{
    const STATUS_CODE_BADGES_NOT_FOUND   = -1;
    const MESSAGE_CODE_BADGE_NOT_FOUND  = 'Badges Not Found';
    const STATUS_CODE_USER_NOT_FOUND  = -2;
    const MESSAGE_CODE_USER_NOT_FOUND = 'User Not Valid';
}
