<?php

namespace Interactor\CommandHandler\GetBadge\Exception;

class InvalidGetBadgeCommandExceptionCode
{
    const STATUS_CODE_BADGE_ID_NOT_PROVIDED          = -1;
    const MESSAGE_CODE_BADGE_ID_NOT_PROVIDED         = 'Badge Id Not Provided';
    const STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED    = -2;
    const MESSAGE_CODE_BADGE_ID_NOT_VALID_PROVIDED   = 'Badge Id Not Valid Provided';
    const STATUS_CODE_USER_ID_NOT_PROVIDED         = -3;
    const MESSAGE_CODE_USER_ID_NOT_PROVIDED        = 'User Id Not Provided';
    const STATUS_CODE_USER_ID_NOT_VALID_PROVIDED   = -4;
    const MESSAGE_CODE_USER_ID_NOT_VALID_PROVIDED  = 'User Id Not Valid Provided';
}
