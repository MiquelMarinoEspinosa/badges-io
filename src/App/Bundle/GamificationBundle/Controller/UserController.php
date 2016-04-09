<?php

namespace App\Bundle\GamificationBundle\Controller;

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
     *      500="Returned when something when wrong",
     *  }
     * )
     */
    public function putUserSigninAction(Request $request)
    {
        $signInCommand = $this->buildSignInCommand($request);

        return $this->container->get(
            'gamification.interactor.command_handler.sign_in.sign_in_command_handler'
        )->handle($signInCommand);
    }

    /**
     * @param Request $request
     *
     * @return SignInCommand
     */
    private function buildSignInCommand(Request $request)
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
     *      500="Returned when something when wrong",
     *  }
     * )
     */
    public function putUserLoginAction(Request $request)
    {
        $logInCommand = $this->buildLogInCommand($request);

        return $this->container->get(
            'gamification.interactor.command_handler.log_in.log_in_command_handler'
        )->handle($logInCommand);
    }

    /**
     * @param Request $request
     *
     * @return LogInCommand
     */
    private function buildLogInCommand(Request $request)
    {
        $userId = $request->get('username') ? $request->get('username') : $request->get('email');

        return new LogInCommand(
            $userId,
            $request->get('password')
        );
    }
}
