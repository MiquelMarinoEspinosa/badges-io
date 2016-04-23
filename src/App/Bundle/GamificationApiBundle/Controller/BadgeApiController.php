<?php

namespace App\Bundle\GamificationApiBundle\Controller;

use App\Bundle\GamificationApiBundle\Controller\ApiHttpExceptionManager\BadgeApiHttpExceptionManager;
use App\Bundle\GamificationApiBundle\Controller\ApiKeyAuthentication\ApiKeyAuthenticatedController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Interactor\CommandHandler\CreateBadge\CreateBadgeCommand;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\CommandHandler\DeleteBadge\DeleteBadgeCommand;
use Interactor\CommandHandler\GetBadge\GetBadgeCommand;
use Interactor\CommandHandler\ListBadges\ListBadgesCommand;
use Interactor\CommandHandler\UpdateBadge\ImageData\ImageData as UpdateImageData;
use Interactor\CommandHandler\CreateBadge\UserData\UserData;
use Interactor\CommandHandler\UpdateBadge\UserData\UserData as UpdateUserData;
use Interactor\CommandHandler\UpdateBadge\UpdateBadgeCommand;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BadgeApiController extends FOSRestController implements ApiKeyAuthenticatedController
{
    /**
     * @ApiDoc(
     *  description = "Create a new badge",
     *  parameters={
     *    {"name"="name", "dataType"="string", "format"="\s+", "description"=" Badge name", "required"="true"},
     *    {
     *      "name"="description",
     *      "dataType"="string",
     *      "format"="\s+",
     *      "description"=" Badge description",
     *      "required"="true"
     *     },
     *    {"name"="userId", "dataType"="string", "format"="\s+", "description"=" User id", "required"="true"},
     *    {
     *     "name"="isMultiUser",
     *     "dataType"="boolean",
     *     "format"="true - false",
     *     "description"=" Shared for all the users or only for its creator",
     *     "required"="true"
     *     },
     *    {
     *     "name"="imageName",
     *     "dataType"="string",
     *     "format"="\s+",
     *     "description"=" Name of the image",
     *     "required"="true"
     *     },
     *    {"name"="imageWidth", "dataType"="string", "format"="\d+", "description"=" Image width", "required"="true"},
     *    {
     *     "name"="imageHeight",
     *     "dataType"="string",
     *     "format"="\d+",
     *     "description"=" Image height",
     *     "required"="true"
     *     },
     *    {"name"="imageFormat", "dataType"="string", "format"="\s+", "description"=" Image format", "required"="true"},
     *    {"name"="imageFile", "dataType"="file", "format"="file", "description"=" Image file", "required"="true"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when some required parameter is missing or its format is not correct",
     *      404="Returned when the user was not found",
     *      500="Returned when something when wrong"
     *  }
     * )
     * @Post("/badge/create")
     */
    public function postBadgeCreateAction(Request $request)
    {
        try {
            $createBadgeCommand = $this->buildCreateBadgeCommandByRequest($request);

            return $this->container->get(
                'gamification.interactor.command_handler.create_badge.create_badge_command_handler'
            )->handle($createBadgeCommand);
        } catch (\Exception $applicationException) {
            throw $this->buildBadgeHttpExceptionManager()
                ->applicationCreateBadgeExceptionToHttpException($applicationException);
        }
    }

    /**
     * @param Request $request
     *
     * @return CreateBadgeCommand
     */
    private function buildCreateBadgeCommandByRequest(Request $request)
    {
        return new CreateBadgeCommand(
            $request->get('name'),
            $request->get('description'),
            (bool) $request->get('isMultiUser'),
            $this->buildUserDataByRequest($request),
            $this->buildImageDataByRequest($request)
        );
    }

    /**
     * @param Request $request
     *
     * @return UserData
     */
    private function buildUserDataByRequest(Request $request)
    {
        return new UserData(
            $request->get('userId')
        );
    }

    /**
     * @param Request $request
     *
     * @return ImageData
     */
    private function buildImageDataByRequest(Request $request)
    {
        return new ImageData(
            $request->get('imageName'),
            (int) $request->get('imageWidth'),
            (int) $request->get('imageHeight'),
            $request->get('imageFormat'),
            $request->files->get('imageFile')->getPathname()
        );
    }

    /**
     * @ApiDoc(
     *  description = "Update a previous badge",
     *  parameters={
     *    {"name"="id", "dataType"="string", "format"="\s+", "description"=" Badge id", "required"="true"},
     *    {"name"="name", "dataType"="string", "format"="\s+", "description"=" Badge name", "required"="true"},
     *    {
     *      "name"="description",
     *      "dataType"="string",
     *      "format"="\s+",
     *      "description"=" Badge description",
     *      "required"="true"
     *     },
     *    {"name"="userId", "dataType"="string", "format"="\s+", "description"=" User id", "required"="true"},
     *    {
     *     "name"="isMultiUser",
     *     "dataType"="boolean",
     *     "format"="true - false",
     *     "description"=" Shared for all the users or only for its creator",
     *     "required"="true"
     *     },
     *    {
     *     "name"="imageName",
     *     "dataType"="string",
     *     "format"="\s+",
     *     "description"=" Name of the image",
     *     "required"="true"
     *     },
     *    {"name"="imageWidth", "dataType"="string", "format"="\d+", "description"=" Image width", "required"="true"},
     *    {
     *     "name"="imageHeight",
     *     "dataType"="string",
     *     "format"="\d+",
     *     "description"=" Image height",
     *     "required"="true"
     *     },
     *    {"name"="imageFormat", "dataType"="string", "format"="\s+", "description"=" Image format", "required"="true"},
     *    {"name"="imageFile", "dataType"="file", "format"="file", "description"=" Image file", "required"="true"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when some required parameter is missing or the format its is not correct",
     *      404="Returned when the badge or the user was not found",
     *      401="Returned when the user is not authorized to do the action",
     *      500="Returned when something when wrong"
     *  }
     * )
     * @Post("/badge/update")
     */
    public function postBadgeUpdateAction(Request $request)
    {
        try {
            $createBadgeCommand = $this->buildUpdateBadgeCommandByRequest($request);

            return $this->container->get(
                'gamification.interactor.command_handler.update_badge.update_badge_command_handler'
            )->handle($createBadgeCommand);
        } catch (\Exception $applicationException) {
            throw $this->buildBadgeHttpExceptionManager()
                ->applicationUpdateBadgeExceptionToHttpException($applicationException);
        }
    }

    /**
     * @param Request $request
     *
     * @return UpdateBadgeCommand
     */
    private function buildUpdateBadgeCommandByRequest(Request $request)
    {
        return new UpdateBadgeCommand(
            $request->get('id'),
            $request->get('name'),
            $request->get('description'),
            (bool) $request->get('isMultiUser'),
            $this->buildUpdateUserDataByRequest($request),
            $this->buildUpdateImageDataByRequest($request)
        );
    }

    /**
     * @param Request $request
     *
     * @return UpdateUserData
     */
    private function buildUpdateUserDataByRequest(Request $request)
    {
        return new UpdateUserData(
            $request->get('userId')
        );
    }

    /**
     * @param Request $request
     *
     * @return UpdateImageData
     */
    private function buildUpdateImageDataByRequest(Request $request)
    {
        return new UpdateImageData(
            $request->get('imageName'),
            (int) $request->get('imageWidth'),
            (int) $request->get('imageHeight'),
            $request->get('imageFormat'),
            $request->files->get('imageFile')->getPathname()
        );
    }

    /**
     * @ApiDoc(
     *  description = "Get a badge by Badge Id",
     *  requirements={
     *    {"name"="id", "dataType"="string", "format"="\s+", "description"=" Badge id", "required"="true"},
     *    {"name"="userId", "dataType"="string", "format"="\s+", "description"=" User id", "required"="true"},
     * },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when some required parameter is missing or the format its is not correct",
     *      404="Returned when the badge or the user was not found",
     *      401="Returned when the user is not authorized to do the action",
     *      500="Returned when something when wrong"
     *  }
     * )
     * @Get("/badge/{id}/{userId}")
     */
    public function getBadgeAction($id, $userId)
    {
        try {
            $getBadgeCommand = $this->buildGetBadgeCommandByRequest($id, $userId);

            return $this->container->get(
                'gamification.interactor.command_handler.get_badge.get_badge_command_handler'
            )->handle($getBadgeCommand);
        } catch (\Exception $applicationException) {
            throw $this->buildBadgeHttpExceptionManager()
                ->applicationGetBadgeExceptionToHttpException($applicationException);
        }
    }

    /**
     * @param string $id
     * @param string $userId
     *
     * @return GetBadgeCommand
     */
    private function buildGetBadgeCommandByRequest($id, $userId)
    {
        return new GetBadgeCommand($id, $userId);
    }

    /**
     * @ApiDoc(
     *  description = "Delete a badge",
     *  requirements={
     *    {"name"="id", "dataType"="string", "format"="\s+", "description"=" Badge id", "required"="true"},
     *    {"name"="userId", "dataType"="string", "format"="\s+", "description"=" User id", "required"="true"}
     * },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when some required parameter is missing or the format its is not correct",
     *      404="Returned when the badge was not found",
     *      401="Returned when the user is not authorized to do the action",
     *      500="Returned when something when wrong"
     *  }
     * )
     * @Delete("/badge/{id}/{userId}")
     */
    public function deleteBadgeAction($id, $userId)
    {
        try {
            $deleteBadgeCommand = $this->buildDeleteBadgeCommandByRequest($id, $userId);

            $this->container->get(
                'gamification.interactor.command_handler.delete_badge.delete_badge_command_handler'
            )->handle($deleteBadgeCommand);

            return $this->buildDeleteMessageResponse($id, $userId);
        } catch (\Exception $applicationException) {
            throw $this->buildBadgeHttpExceptionManager()
                ->applicationDeleteBadgeExceptionToHttpException($applicationException);
        }
    }

    /**
     * @param string $id
     * @param string $userId
     *
     * @return DeleteBadgeCommand
     */
    private function buildDeleteBadgeCommandByRequest($id, $userId)
    {
        return new DeleteBadgeCommand($id, $userId);
    }

    /**
     * @param string $id
     * @param string $userId
     *
     * @return array
     */
    private function buildDeleteMessageResponse($id, $userId)
    {
        return [
            'status'  => "OK",
            'message' => "The badge $id has been removed successfully",
            '_links'  => $this->buildDeleteLinksResources($id, $userId)
        ];
    }

    /**
     * @param string $id
     * @param string $userId
     *
     * @return array
     */
    private function buildDeleteLinksResources($id, $userId)
    {
        $mandatoryParameters = $this->buildDeleteLinksMandatoryParameters($id, $userId);
        $absoluteUrl         = UrlGeneratorInterface::ABSOLUTE_URL;

        return  [
            'create_badge'  => ['href' => $this->generateUrl('post_badge_create', [], $absoluteUrl)],
            'list_badges'   => ['href' => $this->generateUrl('get_badges_list', $mandatoryParameters, $absoluteUrl)],
            'login'         => ['href' => $this->generateUrl('put_user_login', [], $absoluteUrl)],
            'signup'        => ['href' => $this->generateUrl('put_user_sign_up', [], $absoluteUrl)],
        ];
    }

    /**
     * @param string $id
     * @param string $userId
     *
     * @return array
     */
    private function buildDeleteLinksMandatoryParameters($id, $userId)
    {
        return $mandatoryParameters = [
            'id' => $id,
            'userId' => $userId
        ];
    }

    /**
     * @ApiDoc(
     *  description = "Get a list of badges by User Id",
     *  requirements={
     *    {"name"="userId", "dataType"="string", "format"="\s+", "description"=" User id", "required"="true"}
     * },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when some required parameter is missing or the format its is not correct",
     *      404="Returned when user was not found",
     *      500="Returned when something when wrong"
     *  }
     * )
     * @Get("/badges/list/{userId}")
     */
    public function getBadgesListAction($userId)
    {
        try {
            $listBadgesCommand = $this->buildListBadgesCommandByRequest($userId);

            return $this->container->get(
                'gamification.interactor.command_handler.list_badges.list_badges_command_handler'
            )->handle($listBadgesCommand);
        } catch (\Exception $applicationException) {
            throw $this->buildBadgeHttpExceptionManager()
                ->applicationListBadgesExceptionToHttpException($applicationException);
        }
    }

    /**
     * @param string $userId
     *
     * @return ListBadgesCommand
     */
    private function buildListBadgesCommandByRequest($userId)
    {
        return new ListBadgesCommand($userId);
    }

    /**
     * @return BadgeApiHttpExceptionManager
     */
    private function buildBadgeHttpExceptionManager()
    {
        // @codingStandardsIgnoreStart
        return $this->container->get(
            'gamification.app.bundle.gamification_api_bundle.controller.api_http_exception_manager.badge_api_http_exception_manager'
        );
        // @codingStandardsIgnoreEnd
    }
}
