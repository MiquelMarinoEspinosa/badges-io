<?php
namespace App\Bundle\GamificationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Interactor\CommandHandler\SignIn\SignInCommand;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class SignInController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description = "Create a new user",
     *  output = "Infrastructure\Resource\Api\Domain\Entity\User\UserApiResource",
     *  requirements={
     *    {"name"="username", "dataType"="string", "required"="true", "description"="User's Name"},
     *    {"name"="email", "dataType"="string", "required"="true", "description"="User's Mail"},
     *    {"name"="password", "dataType"="password", "required"="true", "description"="User's Password"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      500="Returned when something when wrong",
     *  }
     * )
     */
    public function putSigninAction(Request $request)
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
}
