<?php

namespace Interactor\CommandHandler\LogIn\Exception;

class InvalidLogInCommandExceptionCode
{
    const STATUS_CODE_USER_ID_NOT_PROVIDED          = -1;
    const MESSAGE_CODE_USER_ID_NOT_PROVIDED         = 'User id not provided';
    const STATUS_CODE_USER_ID_NOT_VALID_PROVIDED    = -2;
    const MESSAGE_CODE_USER_ID_NOT_VALID_PROVIDED   = 'User not valid provided';
    const STATUS_CODE_PASSWORD_NOT_PROVIDED         = -3;
    const MESSAGE_CODE_PASSWORD_NOT_PROVIDED        = 'Password not provided';
    const STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED   = -4;
    const MESSAGE_CODE_PASSWORD_NOT_VALID_PROVIDED  = 'Password not valid provided';
}
