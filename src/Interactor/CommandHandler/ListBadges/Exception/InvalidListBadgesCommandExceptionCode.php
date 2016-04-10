<?php

namespace Interactor\CommandHandler\ListBadges\Exception;

class InvalidListBadgesCommandExceptionCode
{
    const STATUS_CODE_USER_ID_NOT_PROVIDED         = -1;
    const MESSAGE_CODE_USER_ID_NOT_PROVIDED        = 'User Id Not Provided';
    const STATUS_CODE_USER_ID_NOT_VALID_PROVIDED   = -2;
    const MESSAGE_CODE_USER_ID_NOT_VALID_PROVIDED  = 'User Id Not Valid Provided';
}
