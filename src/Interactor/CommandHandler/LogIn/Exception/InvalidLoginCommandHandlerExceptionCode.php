<?php

namespace Interactor\CommandHandler\LogIn\Exception;

class InvalidLoginCommandHandlerExceptionCode
{
    const STATUS_CODE_USER_NOT_EXIST  = -1;
    const MESSAGE_CODE_USER_NOT_EXIST = 'User not exist';
    const STATUS_CODE_LOGIN_FAILED    = -2;
    const MESSAGE_CODE_LOGIN_FAILED   = 'Login failed';
}
