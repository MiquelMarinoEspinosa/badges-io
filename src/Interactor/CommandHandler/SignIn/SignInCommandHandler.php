<?php

namespace Interactor\CommandHandler\SignIn;

use Domain\Service\IdGenerator;
use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;
use Domain\Entity\User\UserRepository;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandHandlerException;
use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandHandlerExceptionCode;

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
     * @var IdGenerator
     */
    private $idGenerator;

    public function __construct(
        UserRepository $userRepository,
        UserDataTransformer $userDataTransformer,
        IdGenerator $userIdGenerator
    ) {
        $this->userRepository       = $userRepository;
        $this->userDataTransformer  = $userDataTransformer;
        $this->idGenerator          = $userIdGenerator;
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
        $this->tryToPersistUser($user);

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
        try {
            $user  = $this->userRepository->findByEmail($email);
        } catch (\Exception $exception) {
            $user = null;
            $this->throwUserNotCreatedException();
        }

        if ($aNullUser !== $user) {
            throw $this->buildInvalidSigInCommandHandlerException(
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
        try {
            $user = $this->userRepository->findByUserName($userName);
        } catch (\Exception $exception) {
            $user = null;
            $this->throwUserNotCreatedException();
        }

        if ($aNullUser !== $user) {
            throw $this->buildInvalidSigInCommandHandlerException(
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
            $this->idGenerator->generateId(),
            $command->email(),
            $command->userName(),
            $command->passWord()
        );
    }

    /**
     * @param User $user
     */
    private function tryToPersistUser($user)
    {
        try {
            $this->userRepository->persist($user);
        } catch (\Exception $exception) {
            $this->throwUserNotCreatedException();
        }
    }

    /**
     * @throws InvalidSignInCommandHandlerException
     */
    private function throwUserNotCreatedException()
    {
        throw $this->buildInvalidSigInCommandHandlerException(
            InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED
        );
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidSignInCommandHandlerException
     */
    private function buildInvalidSigInCommandHandlerException($statusCode)
    {
        return new InvalidSignInCommandHandlerException(
            $statusCode
        );
    }
}
