<?php

namespace App\Bundle\GamificationApiBundle\Controller\ApiHttpExceptionManager;

use Interactor\CommandHandler\CreateBadge\ImageData\Exception\InvalidImageDataException;
use Interactor\CommandHandler\CreateBadge\UserData\Exception\InvalidUserDataException;
use Interactor\CommandHandler\UpdateBadge\ImageData\Exception\InvalidImageDataException as InvalidUpdateImageDataException;
use Interactor\CommandHandler\UpdateBadge\UserData\Exception\InvalidUserDataException as InvalidUpdateUserDataException;
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

class BadgeApiHttpExceptionManager
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
        if ($applicationException instanceof InvalidCreateBadgeCommandException
            || $applicationException instanceof InvalidImageDataException
            || $applicationException instanceof InvalidUserDataException
        ) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidCreateBadgeCommandHandlerException) {
            $statusCode = static::CREATE_BADGE_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->buildHttpException($applicationException, $statusCode);
    }

    /**
     * @param \Exception $applicationException
     *
     * @return HttpException
     */
    public function applicationUpdateBadgeExceptionToHttpException(\Exception $applicationException)
    {
        if ($applicationException instanceof InvalidUpdateBadgeCommandException
            || $applicationException instanceof InvalidUpdateImageDataException
            || $applicationException instanceof InvalidUpdateUserDataException
        ) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($applicationException instanceof InvalidUpdateBadgeCommandHandlerException) {
            $statusCode = static::UPDATE_BADGE_MAP_HTTP_CODE_EXCEPTION[$applicationException->getCode()];
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->buildHttpException($applicationException, $statusCode);
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

        return $this->buildHttpException($applicationException, $statusCode);
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

        return $this->buildHttpException($applicationException, $statusCode);
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

        return $this->buildHttpException($applicationException, $statusCode);
    }

    /**
     * @param \Exception $applicationException
     * @param string $statusCode
     *
     * @return HttpException
     */
    private function buildHttpException(\Exception $applicationException, $statusCode)
    {
        return new HttpException($statusCode, $applicationException->getMessage());
    }
}
