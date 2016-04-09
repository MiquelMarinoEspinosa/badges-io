<?php

namespace Test\Interactor\CommandHandler\LogIn;

use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;
use Domain\Service\PasswordCipher;
use Infrastructure\DataTransformer\NoOperation\Domain\Entity\User\UserNoOpDataTransformer;
use Infrastructure\Persistence\InMemory\Domain\Entity\User\InMemoryUserRepository;
use Infrastructure\Services\Domain\PasswordCipher\MD5PasswordCipher;
use Interactor\CommandHandler\LogIn\Exception\InvalidLoginCommandHandlerException;
use Interactor\CommandHandler\LogIn\Exception\InvalidLoginCommandHandlerExceptionCode;
use Interactor\CommandHandler\LogIn\LogInCommand;
use Interactor\CommandHandler\LogIn\LoginCommandHandler;
use Test\Domain\Entity\User\FakeUserBuilder;
use Test\Domain\Entity\User\FakeUserRepositoryThrownException;

class LoginCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const USER_ID                               = '123';
    const EMAIL_EXISTS_TEST_BADGES_IO_COM       = 'test@badges-io.com';
    const EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM   = 'myEmail@badges-io.com';
    const USERNAME_EXISTS_VALID_BADGES_USER     = 'badgesUser';
    const USERNAME_NOT_EXISTS_VALID_BADGES_USER = 'userBadges';
    const PASSWORD_VALID_NOT_EXISTS_EMPTY       = ' ';
    const PASSWORD_VALID_EXISTS_BE_FREE         = 'B3FR33';

    /**
     * @test
     */
    public function repositoryFailsFindByEmailShouldThrownExceptionLoginFailedStatusCode()
    {
        try {
            $command = $this->buildCommand(
                static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                static::PASSWORD_VALID_NOT_EXISTS_EMPTY
            );

            $commandHandler = $this->buildCommandHandler(
                $this->buildUserRepositoryThrowException(
                    FakeUserRepositoryThrownException::FIND_BY_EMAIL_METHOD_THROW_EXCEPTION
                )
            );
            $commandHandler->handle($command);

            $this->thisTestFails();
        } catch (InvalidLoginCommandHandlerException $invalidLoginCommandHandlerException) {
            $this->assertEquals(
                InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED,
                $invalidLoginCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function repositoryFailsFindByUserNameShouldThrownExceptionLoginFailedStatusCode()
    {
        try {
            $command = $this->buildCommand(
                static::USERNAME_EXISTS_VALID_BADGES_USER,
                static::PASSWORD_VALID_NOT_EXISTS_EMPTY
            );

            $commandHandler = $this->buildCommandHandler(
                $this->buildUserRepositoryThrowException(
                    FakeUserRepositoryThrownException::FIND_BY_USER_NAME_METHOD_THROW_EXCEPTION
                )
            );
            $commandHandler->handle($command);

            $this->thisTestFails();
        } catch (InvalidLoginCommandHandlerException $invalidLoginCommandHandlerException) {
            $this->assertEquals(
                InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED,
                $invalidLoginCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function emailNotExistsShouldThrownExceptionUserNotExistStatusCode()
    {
        try {
            $command = $this->buildCommand(
                static::EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM,
                static::PASSWORD_VALID_NOT_EXISTS_EMPTY
            );
            $commandHandler = $this->buildCommandHandler($this->buildDefaultUserRepository());
            $commandHandler->handle($command);

            $this->thisTestFails();
        } catch (InvalidLoginCommandHandlerException $invalidLoginCommandHandlerException) {
            $this->assertEquals(
                InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_EXIST,
                $invalidLoginCommandHandlerException->code()
            );
        }
    }


    /**
     * @test
     */
    public function usernameNotExistsShouldThrownExceptionUserNotExistStatusCode()
    {
        try {
            $command = $this->buildCommand(
                static::USERNAME_NOT_EXISTS_VALID_BADGES_USER,
                static::PASSWORD_VALID_NOT_EXISTS_EMPTY
            );
            $commandHandler = $this->buildCommandHandler($this->buildDefaultUserRepository());
            $commandHandler->handle($command);

            $this->thisTestFails();
        } catch (InvalidLoginCommandHandlerException $invalidLoginCommandHandlerException) {
            $this->assertEquals(
                InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_EXIST,
                $invalidLoginCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function passwordNotMatchWithEmailShouldThrownExceptionLoginFailedStatusCode()
    {
        try {
            $command = $this->buildCommand(
                static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                static::PASSWORD_VALID_NOT_EXISTS_EMPTY
            );
            $commandHandler = $this->buildCommandHandler($this->buildDefaultUserRepository());
            $commandHandler->handle($command);

            $this->thisTestFails();
        } catch (InvalidLoginCommandHandlerException $invalidLoginCommandHandlerException) {
            $this->assertEquals(
                InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED,
                $invalidLoginCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function passwordNotMatchWithUserNameShouldThrownExceptionLoginFailedStatusCode()
    {
        try {
            $command = $this->buildCommand(
                static::USERNAME_EXISTS_VALID_BADGES_USER,
                static::PASSWORD_VALID_NOT_EXISTS_EMPTY
            );
            $commandHandler = $this->buildCommandHandler($this->buildDefaultUserRepository());
            $commandHandler->handle($command);

            $this->thisTestFails();
        } catch (InvalidLoginCommandHandlerException $invalidLoginCommandHandlerException) {
            $this->assertEquals(
                InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED,
                $invalidLoginCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function validEmailCredentialsShouldReturnTheUser()
    {
        $command = $this->buildCommand(
            static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
            static::PASSWORD_VALID_EXISTS_BE_FREE
        );
        $commandHandler = $this->buildCommandHandler($this->buildDefaultUserRepository());
        /** @var User $user */
        $user = $commandHandler->handle($command);
        $passwordCipher = $this->buildPasswordCipher();

        $this->assertTrue(
            $user->userName() === static::USERNAME_EXISTS_VALID_BADGES_USER
            && $user->passWord() === $passwordCipher->cipher(static::PASSWORD_VALID_EXISTS_BE_FREE)
        );
    }

    /**
     * @test
     */
    public function validUsernameCredentialsShouldReturnTheUser()
    {
        $command = $this->buildCommand(
            static::USERNAME_EXISTS_VALID_BADGES_USER,
            static::PASSWORD_VALID_EXISTS_BE_FREE
        );
        $commandHandler = $this->buildCommandHandler($this->buildDefaultUserRepository());
        /** @var User $user */
        $user = $commandHandler->handle($command);
        $passwordCipher = $this->buildPasswordCipher();

        $this->assertTrue(
            $user->userName() === static::USERNAME_EXISTS_VALID_BADGES_USER
            && $user->passWord() === $passwordCipher->cipher(static::PASSWORD_VALID_EXISTS_BE_FREE)
        );
    }

    /**
     * @param UserRepository $userRepository
     *
     * @return LoginCommandHandler
     */
    private function buildCommandHandler($userRepository)
    {
        return new LoginCommandHandler(
            $userRepository,
            $this->buildUserDataTransformer(),
            $this->buildPasswordCipher()
        );
    }

    /**
     * @return UserRepository
     */
    private function buildDefaultUserRepository()
    {
        return new InMemoryUserRepository($this->buildDefaultUsers());
    }

    /**
     * @return User[]
     */
    private function buildDefaultUsers()
    {
        $passwordCipher = $this->buildPasswordCipher();
        return [
            FakeUserBuilder::build(
                static::USER_ID,
                static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                static::USERNAME_EXISTS_VALID_BADGES_USER,
                $passwordCipher->cipher(static::PASSWORD_VALID_EXISTS_BE_FREE)
            )
        ];
    }

    /**
     * @return UserNoOpDataTransformer
     */
    private function buildUserDataTransformer()
    {
        return new UserNoOpDataTransformer();
    }

    /**
     * @param string $email
     * @param string $passWord
     *
     * @return LogInCommand
     */
    private function buildCommand($email, $passWord)
    {
        return new LogInCommand($email, $passWord);
    }

    /**
     * @param int $methodException
     *
     * @return FakeUserRepositoryThrownException
     */
    private function buildUserRepositoryThrowException($methodException)
    {
        return new FakeUserRepositoryThrownException($this->buildDefaultUsers(), $methodException);
    }

    /**
     * @return PasswordCipher
     */
    private function buildPasswordCipher()
    {
        return new MD5PasswordCipher();
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
