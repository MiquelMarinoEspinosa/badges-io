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
