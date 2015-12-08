<?php

namespace Interactor\CommandHandler\LogIn;

use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;
use Domain\Entity\User\UserRepository;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\LogIn\Exception\InvalidLoginCommandHandlerException;
use Interactor\CommandHandler\LogIn\Exception\InvalidLoginCommandHandlerExceptionCode;

class LoginCommandHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserDataTransformer
     */
    private $userDataTransformer;

    public function __construct(UserRepository $userRepository, UserDataTransformer $userDataTransformer)
    {
        $this->userRepository      = $userRepository;
        $this->userDataTransformer = $userDataTransformer;
    }

    /**
     * @param LoginCommand $command
     *
     * @return mixed
     * @throws InvalidLoginCommandHandlerException
     */
    public function handle($command)
    {
        $userByEmail = $this->tryToFindByEmail($command->userId());

        if ($userByEmail instanceof User) {
            if ($userByEmail->passWord() !== $command->passWord()) {
                throw $this->buildInvalidLogInCommandHandlerException(
                    InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED
                );
            }

            return $this->userDataTransformer->transform($userByEmail);
        }

        $userByUsername = $this->tryToFindByUserName($command->userId());

        if ($userByUsername instanceof User) {
            if ($userByUsername->passWord() !== $command->passWord()) {
                throw $this->buildInvalidLogInCommandHandlerException(
                    InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED
                );
            }

            return $this->userDataTransformer->transform($userByUsername);
        }

        throw $this->buildInvalidLogInCommandHandlerException(
            InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_EXIST
        );
    }

    /**
     * @param $userId
     *
     * @return User|null
     * @throws InvalidLoginCommandHandlerException
     */
    private function tryToFindByEmail($userId)
    {
        try {
            $userByEmail = $this->userRepository->findByEmail($userId);
        } catch (\Exception $exception) {
            throw $this->buildInvalidLogInCommandHandlerException(
                InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED
            );
        }

        return $userByEmail;
    }

    /**
     * @param $userId
     *
     * @return User|null
     * @throws InvalidLoginCommandHandlerException
     */
    private function tryToFindByUserName($userId)
    {
        try {
            $userByUserName = $this->userRepository->findByUsername($userId);
        } catch (\Exception $exception) {
            throw $this->buildInvalidLogInCommandHandlerException(
                InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED
            );
        }

        return $userByUserName;
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidLoginCommandHandlerException
     */
    private function buildInvalidLogInCommandHandlerException($statusCode)
    {
        return new InvalidLoginCommandHandlerException($statusCode);
    }
}
