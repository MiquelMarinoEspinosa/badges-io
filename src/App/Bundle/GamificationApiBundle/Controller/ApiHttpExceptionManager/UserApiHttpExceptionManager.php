<?php

namespace App\Bundle\GamificationApiBundle\Controller\ApiHttpExceptionManager;

use Interactor\CommandHandler\LogIn\Exception\InvalidLogInCommandException;
use Interactor\CommandHandler\LogIn\Exception\InvalidLoginCommandHandlerException;
use Interactor\CommandHandler\LogIn\Exception\InvalidLoginCommandHandlerExceptionCode;
use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandException;
use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandHandlerException;
use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandHandlerExceptionCode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserApiHttpExceptionManager
{
    const SIGN_IN_MAP_HTTP_CODE_EXCEPTION = [
        InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED =>
            Response::HTTP_INTERNAL_SERVER_ERROR,
        InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS =>
            Response::HTTP_BAD_REQUEST,
        InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS =>
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
    public function applicationSignUpExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidSignUpCommandException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidSignUpCommandHandlerException) {
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
