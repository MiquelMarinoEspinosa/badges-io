<?php

namespace Interactor\CommandHandler\SignUp\Exception;

class InvalidSignUpCommandHandlerExceptionCode
{
    const STATUS_CODE_USER_NOT_CREATED          = -1;
    const MESSAGE_CODE_USER_NOT_CREATED         = 'User not created';
    const STATUS_CODE_EMAIL_ALREADY_EXISTS      = -2;
    const MESSAGE_CODE_EMAIL_ALREADY_EXISTS     = 'Email already exists';
    const STATUS_CODE_USERNAME_ALREADY_EXISTS   = -3;
    const MESSAGE_CODE_USERNAME_ALREADY_EXISTS  = 'Username already exists';
}
