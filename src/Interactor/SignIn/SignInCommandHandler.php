<?php

namespace Interactor\SignIn;

use Domain\User\Service\UserIdGenerator;
use Domain\User\User;
use Domain\User\UserDataTransformer;
use Domain\User\UserRepository;
use Interactor\CommandHandler;
use Interactor\SignIn\Exception\InvalidSignInCommandHandlerException;
use Interactor\SignIn\Exception\InvalidSignInCommandHandlerExceptionCode;

class SignInCommandHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserDataTransformer
     */
    private $userDataTransformer;
    /**
     * @var UserIdGenerator
     */
    private $userIdGenerator;

    public function __construct(
        UserRepository $userRepository,
        UserDataTransformer $userDataTransformer,
        UserIdGenerator $userIdGenerator
    ) {
        $this->userRepository       = $userRepository;
        $this->userDataTransformer  = $userDataTransformer;
        $this->userIdGenerator      = $userIdGenerator;
    }

    /**
     * @param SignInCommand $command
     *
     * @return mixed
     * @throws InvalidSignInCommandHandlerException
     */
    public function handle($command)
    {
        $this->validate($command);
        $user = $this->buildUser($command);
        $this->userRepository->persist($user);

        return $this->userDataTransformer->transform($user);
    }

    /**
     * @param SignInCommand $command
     *
     * @throws InvalidSignInCommandHandlerException
     */
    private function validate($command)
    {
        $this->checkNoUserExistsWithThisEmail($command->email());
        $this->checkNoUserExistsWithThisUserName($command->userName());
    }

    /**
     * @param string $email
     *
     * @throws InvalidSignInCommandHandlerException
     */
    private function checkNoUserExistsWithThisEmail($email)
    {
        $aNullUser  = null;
        $user       = $this->userRepository->findByEmail($email);
        if ($aNullUser !== $user) {
            throw new InvalidSignInCommandHandlerException(
                InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS
            );
        }
    }

    /**
     * @param string $userName
     *
     * @throws InvalidSignInCommandHandlerException
     */
    private function checkNoUserExistsWithThisUserName($userName)
    {
        $aNullUser  = null;
        $user       = $this->userRepository->findByUserName($userName);
        if ($aNullUser !== $user) {
            throw new InvalidSignInCommandHandlerException(
                InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS
            );
        }
    }

    /**
     * @param SignInCommand $command
     *
     * @return User
     */
    private function buildUser($command)
    {
        return new User(
            $this->userIdGenerator->generateId(),
            $command->email(),
            $command->userName(),
            $command->passWord()
        );
    }
}
