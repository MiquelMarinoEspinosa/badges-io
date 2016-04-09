<?php
namespace App\Bundle\GamificationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Interactor\CommandHandler\LogIn\LogInCommand;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class LogInController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description = "Login into the system",
     *  output = "Infrastructure\Resource\Api\Domain\Entity\User\UserApiResource",
     *  requirements={
     *    {"name"="username", "dataType"="string", "description"="User's Name"},
     *    {"name"="email", "dataType"="string", "description"="User's Mail"},
     *    {"name"="password", "dataType"="password", "description"="User's Password"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      500="Returned when something when wrong",
     *  }
     * )
     */
    public function getLoginAction(Request $request)
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
