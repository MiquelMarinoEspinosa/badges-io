<?php

namespace App\Bundle\GamificationBundle\Controller;

use App\Bundle\GamificationBundle\Controller\HttpExceptionManager\UserHttpExceptionManager;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Interactor\CommandHandler\LogIn\LogInCommand;
use Interactor\CommandHandler\SignIn\SignInCommand;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class UserController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description = "Create a new user",
     *  output = "Infrastructure\Resource\Api\Domain\Entity\User\UserApiResource",
     *  parameters={
     *    {"name"="username", "dataType"="string", "format"="\s+", "description"=" User's Name", "required"="true"},
     *    {"name"="email", "dataType"="string", "format"="\s+", "description"=" User's Mail", "required"="true"},
     *    {"name"="password", "dataType"="string", "format"="\s+", "description"=" User's Password", "required"="true"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when some required parameter is missing or the format its is not correct or
            email / username already exists",
     *      500="Returned when something when wrong"
     *  }
     * )
     * @Put("/user/signin")
     */
    public function putUserSignInAction(Request $request)
    {
        try {
            $signInCommand = $this->buildSignInCommandByRequest($request);

            return $this->container->get(
                'gamification.interactor.command_handler.sign_in.sign_in_command_handler'
            )->handle($signInCommand);
        } catch (\Exception $applicationException) {
            throw $this->buildUserHttpExceptionManager()
                ->applicationSignInExceptionToHttpException($applicationException);
        }
    }


    /**
     * @param Request $request
     *
     * @return SignInCommand
     */
    private function buildSignInCommandByRequest(Request $request)
    {
        return new SignInCommand(
            $request->get('email'),
            $request->get('username'),
            $request->get('password')
        );
    }

    /**
     * @ApiDoc(
     *  description = "Login into the system",
     *  output = "Infrastructure\Resource\Api\Domain\Entity\User\UserApiResource",
     *  parameters={
     *    {"name"="username", "dataType"="string", "format"="\s+", "description"=" User's Name", "required"="true"},
     *    {"name"="email", "dataType"="string", "format"="\s+", "description"=" User's Mail", "required"="true"},
     *    {"name"="password", "dataType"="string", "format"="\s+", "description"=" User's Password", "required"="true"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when some required parameter is missing or the format its is not correct",
     *      404="User not found",
     *      403="Login failed",
     *      500="Returned when something when wrong"
     *  }
     * )
     */
    public function putUserLoginAction(Request $request)
    {
        try {
            $logInCommand = $this->buildLogInCommandByRequest($request);

            return $this->container->get(
                'gamification.interactor.command_handler.log_in.log_in_command_handler'
            )->handle($logInCommand);
        } catch (\Exception $applicationException) {
            throw $this->buildUserHttpExceptionManager()
                ->applicationLoginExceptionToHttpException($applicationException);
        }
    }

    /**
     * @param Request $request
     *
     * @return LogInCommand
     */
    private function buildLogInCommandByRequest(Request $request)
    {
        $userId = $request->get('username') ? $request->get('username') : $request->get('email');

        return new LogInCommand(
            $userId,
            $request->get('password')
        );
    }

    /**
     * @return UserHttpExceptionManager
     */
    private function buildUserHttpExceptionManager()
    {
        return $this->container->get(
            'gamification.app.bundle.gamification_bundle.controller.http_exception.manager.user_http_exception_manager'
        );
    }
}
