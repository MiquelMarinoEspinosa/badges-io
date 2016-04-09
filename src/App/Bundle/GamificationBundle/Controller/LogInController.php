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
     *  parameters={
     *    {"name"="username", "dataType"="string", "format"="\s+", "description"="User's Name", "required"="true"},
     *    {"name"="email", "dataType"="string", "format"="\s+", "description"="User's Mail", "required"="true"},
     *    {"name"="password", "dataType"="string", "format"="\s+", "description"="User's Password", "required"="true"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      500="Returned when something when wrong",
     *  }
     * )
     */
    public function putLoginAction(Request $request)
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
