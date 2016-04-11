<?php
namespace App\Bundle\GamificationBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Interactor\CommandHandler\CreateBadge\CreateBadgeCommand;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\CommandHandler\CreateBadge\UserData\UserData;
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

    private function buildImageDataByRequest(Request $request)
    {
        return new ImageData(
            $request->get('imageName'),
            (int) $request->get('imageWidth'),
            (int) $request->get('imageHeight'),
            $request->get('imageFormat')
        );
    }
}