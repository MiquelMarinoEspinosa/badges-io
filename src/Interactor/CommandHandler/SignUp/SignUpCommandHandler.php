<?php

namespace Interactor\CommandHandler\SignUp;

use Domain\Service\IdGenerator;
use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;
use Domain\Entity\User\UserRepository;
use Domain\Service\PasswordCipher;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandHandlerException;
use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandHandlerExceptionCode;

class SignUpCommandHandler implements CommandHandler
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
    /**
     * @var PasswordCipher
     */
    private $passwordCipher;

    public function __construct(
        UserRepository $userRepository,
        UserDataTransformer $userDataTransformer,
        IdGenerator $userIdGenerator,
        PasswordCipher $passwordCipher
    ) {
        $this->userRepository       = $userRepository;
        $this->userDataTransformer  = $userDataTransformer;
        $this->idGenerator          = $userIdGenerator;
        $this->passwordCipher       = $passwordCipher;
    }

    /**
     * @param SignUpCommand $command
     *
     * @return mixed
     * @throws InvalidSignUpCommandHandlerException
     */
    public function handle($command)
    {
        $this->validate($command);
        $user = $this->buildUser($command);
        $this->tryToPersistUser($user);

        return $this->userDataTransformer->transform($user);
    }

    /**
     * @param SignUpCommand $command
     *
     * @throws InvalidSignUpCommandHandlerException
     */
    private function validate($command)
    {
        $this->checkNoUserExistsWithThisEmail($command->email());
        $this->checkNoUserExistsWithThisUserName($command->userName());
    }

    /**
     * @param string $email
     *
     * @throws InvalidSignUpCommandHandlerException
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
                InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS
            );
        }
    }

    /**
     * @param string $userName
     *
     * @throws InvalidSignUpCommandHandlerException
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
                InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS
            );
        }
    }

    /**
     * @param SignUpCommand $command
     *
     * @return User
     */
    private function buildUser($command)
    {
        return new User(
            $this->idGenerator->generateId(),
            $command->email(),
            $command->userName(),
            $this->passwordCipher->cipher($command->passWord())
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
     * @throws InvalidSignUpCommandHandlerException
     */
    private function throwUserNotCreatedException()
    {
        throw $this->buildInvalidSigInCommandHandlerException(
            InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED
        );
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidSignUpCommandHandlerException
     */
    private function buildInvalidSigInCommandHandlerException($statusCode)
    {
        return new InvalidSignUpCommandHandlerException(
            $statusCode
        );
    }
}
