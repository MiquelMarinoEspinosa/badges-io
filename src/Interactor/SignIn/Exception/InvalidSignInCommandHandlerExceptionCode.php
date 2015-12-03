<?php

namespace Interactor\SignIn\Exception;

class InvalidSignInCommandHandlerExceptionCode
{
    const STATUS_CODE_EMAIL_ALREADY_EXISTS      = -1;
    const MESSAGE_CODE_EMAIL_ALREADY_EXISTS     = 'Email already exists';
    const STATUS_CODE_USERNAME_ALREADY_EXISTS   = -2;
    const MESSAGE_CODE_USERNAME_ALREADY_EXISTS  = 'Username already exists';
}
