<?php

namespace App\Bundle\GamificationBundle\Controller\HttpExceptionManager;

use Interactor\CommandHandler\LogIn\Exception\InvalidLogInCommandException;
use Interactor\CommandHandler\LogIn\Exception\InvalidLoginCommandHandlerException;
use Interactor\CommandHandler\LogIn\Exception\InvalidLoginCommandHandlerExceptionCode;
use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandException;
use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandHandlerException;
use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandHandlerExceptionCode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserHttpExceptionManager
{
    const SIGN_IN_MAP_HTTP_CODE_EXCEPTION = [
        InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED =>
            Response::HTTP_INTERNAL_SERVER_ERROR,
        InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS =>
            Response::HTTP_BAD_REQUEST,
        InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS =>
            Response::HTTP_BAD_REQUEST
    ];

    const LOG_IN_MAP_HTTP_CODE_EXCEPTION = [
        InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_EXIST =>
            Response::HTTP_NOT_FOUND,
        InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED =>
            Response::HTTP_FORBIDDEN
    ];

    /**
     * @param \Exception $applicationException
     *
     * @return HttpException
     */
    public function applicationSignInExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidSignInCommandException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidSignInCommandHandlerException) {
            $statusCode = static::SIGN_IN_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new HttpException($statusCode, $applicationException->getMessage());
    }

    /**
     * @param \Exception $applicationException
     *
     * @return HttpException
     */
    public function applicationLogInExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidLogInCommandException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidLoginCommandHandlerException) {
            $statusCode = static::LOG_IN_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new HttpException($statusCode, $applicationException->getMessage());
    }
}
