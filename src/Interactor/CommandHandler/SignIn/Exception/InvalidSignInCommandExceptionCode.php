<?php

namespace Interactor\CommandHandler\SignIn\Exception;

class InvalidSignInCommandExceptionCode
{
    const STATUS_CODE_EMAIL_NOT_PROVIDED            = -1;
    const MESSAGE_CODE_EMAIL_NOT_PROVIDED           = 'Email not provided';
    const STATUS_CODE_EMAIL_NOT_VALID_PROVIDED      = -2;
    const MESSAGE_CODE_EMAIL_NOT_VALID_PROVIDED     = 'Email not valid provided';
    const STATUS_CODE_USERNAME_NOT_PROVIDED         = -3;
    const MESSAGE_CODE_USERNAME_NOT_PROVIDED        = 'Username not provided';
    const STATUS_CODE_USERNAME_NOT_VALID_PROVIDED   = -4;
    const MESSAGE_CODE_USERNAME_NOT_VALID_PROVIDED  = 'Username not valid provided';
    const STATUS_CODE_PASSWORD_NOT_PROVIDED         = -5;
    const MESSAGE_CODE_PASSWORD_NOT_PROVIDED        = 'Password not provided';
    const STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED   = -6;
    const MESSAGE_CODE_PASSWORD_NOT_VALID_PROVIDED  = 'Password not provided';
}
