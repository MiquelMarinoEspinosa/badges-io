<?php

namespace App\Bundle\GamificationBundle\Controller\HttpExceptionManager;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandException;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandHandlerException;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandException;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandHandlerException;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandHandlerExceptionCode;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerExceptionCode;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandException;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerException;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandHandlerExceptionCode;
use Symfony\Component\HttpFoundation\Response;

class BadgeHttpExceptionManager
{
    const UPDATE_BADGE_MAP_HTTP_CODE_EXCEPTION = [
        InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND =>
            Response::HTTP_NOT_FOUND,
        InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN =>
            Response::HTTP_UNAUTHORIZED,
        InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_UPDATED =>
            Response::HTTP_INTERNAL_SERVER_ERROR,
        InvalidUpdateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND =>
            Response::HTTP_NOT_FOUND
    ];

    const CREATE_BADGE_MAP_HTTP_CODE_EXCEPTION = [
        InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND =>
            Response::HTTP_NOT_FOUND,
        InvalidCreateBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_CREATED =>
            Response::HTTP_INTERNAL_SERVER_ERROR
    ];

    const GET_BADGE_MAP_HTTP_CODE_EXCEPTION = [
        InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND =>
            Response::HTTP_NOT_FOUND,
        InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN =>
            Response::HTTP_UNAUTHORIZED
    ];

    const DELETE_BADGE_MAP_HTTP_CODE_EXCEPTION = [
        InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND =>
            Response::HTTP_NOT_FOUND,
        InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN =>
            Response::HTTP_UNAUTHORIZED,
        InvalidDeleteBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_REMOVED =>
            Response::HTTP_INTERNAL_SERVER_ERROR
    ];

    const LIST_BADGES_MAP_HTTP_CODE_EXCEPTION = [
        InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND =>
            Response::HTTP_INTERNAL_SERVER_ERROR,
        InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND =>
            Response::HTTP_NOT_FOUND,
    ];

    /**
     * @param \Exception $applicationException
     *
     * @return HttpException
     */
    public function applicationCreateBadgeExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidCreateBadgeCommandException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidCreateBadgeCommandHandlerException) {
            $statusCode = static::CREATE_BADGE_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
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
    public function applicationUpdateBadgeExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidUpdateBadgeCommandException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidUpdateBadgeCommandHandlerException) {
            $statusCode = static::UPDATE_BADGE_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
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
    public function applicationGetBadgeExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidGetBadgeCommandException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidGetBadgeCommandHandlerException) {
            $statusCode = static::GET_BADGE_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
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
    public function applicationDeleteBadgeExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidDeleteBadgeCommandException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidDeleteBadgeCommandHandlerException) {
            $statusCode = static::DELETE_BADGE_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
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
    public function applicationListBadgesExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidListBadgesCommandException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidListBadgesCommandHandlerException) {
            $statusCode = static::LIST_BADGES_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new HttpException($statusCode, $applicationException->getMessage());
    }
}
