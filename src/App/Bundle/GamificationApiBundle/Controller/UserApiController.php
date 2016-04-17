<?php

namespace App\Bundle\GamificationApiBundle\Controller;

use App\Bundle\GamificationApiBundle\Controller\ApiHttpExceptionManager\UserApiHttpExceptionManager;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Interactor\CommandHandler\LogIn\LogInCommand;
use Interactor\CommandHandler\SignUp\SignUpCommand;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class UserApiController extends FOSRestController
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
     * @Put("/user/signup")
     */
    public function putUserSignUpAction(Request $request)
    {
        try {
            $signUpCommand = $this->buildSignUpCommandByRequest($request);

            return $this->container->get(
                'gamification.interactor.command_handler.sign_up.sign_up_command_handler'
            )->handle($signUpCommand);
        } catch (\Exception $applicationException) {
            throw $this->buildUserHttpExceptionManager()
                ->applicationSignUpExceptionToHttpException($applicationException);
        }
    }


    /**
     * @param Request $request
     *
     * @return SignUpCommand
     */
    private function buildSignUpCommandByRequest(Request $request)
    {
        return new SignUpCommand(
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
     * @return UserApiHttpExceptionManager
     */
    private function buildUserHttpExceptionManager()
    {
        // @codingStandardsIgnoreStart
        return $this->container->get(
            'gamification.app.bundle.gamification_api_bundle.controller.api_http_exception_manager.user_api_http_exception_manager'
        );
        // @codingStandardsIgnoreEnd
    }
}
