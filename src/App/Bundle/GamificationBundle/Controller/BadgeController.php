<?php
namespace App\Bundle\GamificationBundle\Controller;

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

class BadgeController extends FOSRestController
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
     *      500="Returned when something when wrong",
     *  }
     * )
     * @Post("/badge/create")
     */
    public function postBadgeCreateAction(Request $request)
    {
        $createBadgeCommand = $this->buildCreateBadgeCommandByRequest($request);

        return $this->container->get(
            'gamification.interactor.command_handler.create_badge.create_badge_command_handler'
        )->handle($createBadgeCommand);
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
     *      500="Returned when something when wrong",
     *  }
     * )
     * @Post("/badge/update")
     */
    public function postBadgeUpdateAction(Request $request)
    {
        $createBadgeCommand = $this->buildUpdateBadgeCommandByRequest($request);

        return $this->container->get(
            'gamification.interactor.command_handler.update_badge.update_badge_command_handler'
        )->handle($createBadgeCommand);
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
            $request->get('imageFormat')
        );
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
            $request->get('imageFormat')
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
     *      500="Returned when something when wrong",
     *  }
     * )
     * @Get("/badge/{id}/{userId}")
     */
    public function getBadgeAction($id, $userId)
    {
        $getBadgeCommand = $this->buildGetBadgeCommandByRequest($id, $userId);

        return $this->container->get(
            'gamification.interactor.command_handler.get_badge.get_badge_command_handler'
        )->handle($getBadgeCommand);
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
     *      500="Returned when something when wrong",
     *  }
     * )
     * @Delete("/badge/{id}/{userId}")
     */
    public function deleteBadgeAction($id, $userId)
    {
        $deleteBadgeCommand = $this->buildDeleteBadgeCommandByRequest($id, $userId);

        $this->container->get(
            'gamification.interactor.command_handler.delete_badge.delete_badge_command_handler'
        )->handle($deleteBadgeCommand);

        return [
            'status'  => "OK",
            'message' => "The badge $id has been removed successfully"
        ];
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
     * @ApiDoc(
     *  description = "Get a list of badges by User Id",
     *  requirements={
     *    {"name"="userId", "dataType"="string", "format"="\s+", "description"=" User id", "required"="true"}
     * },
     *  statusCodes={
     *      200="Returned when successful",
     *      500="Returned when something when wrong",
     *  }
     * )
     * @Get("/badges/list/{userId}")
     */
    public function getBadgesListAction($userId)
    {
        $listBadgesCommand = $this->buildListBadgesCommandByRequest($userId);

        return $this->container->get(
            'gamification.interactor.command_handler.list_badges.list_badges_command_handler'
        )->handle($listBadgesCommand);
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
}
