<?php

namespace Test\Interactor\CommandHandler\SignUp;

use Domain\Service\IdGenerator;
use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;
use Domain\Entity\User\UserRepository;
use Domain\Service\PasswordCipher;
use Infrastructure\DataTransformer\NoOperation\Domain\Entity\User\UserNoOpDataTransformer;
use Infrastructure\Persistence\InMemory\Domain\Entity\User\InMemoryUserRepository;
use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandHandlerException;
use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandHandlerExceptionCode;
use Interactor\CommandHandler\SignUp\SignUpCommand;
use Interactor\CommandHandler\SignUp\SignUpCommandHandler;
use Test\Domain\Service\FakeIdGenerator;
use Test\Domain\Entity\User\FakeUserBuilder;
use Test\Domain\Entity\User\FakeUserRepositoryThrownException;
use Test\Domain\Service\FakePasswordCipher;

class SignUpCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    const USER_ID                               = '123';
    const EMAIL_EXISTS_TEST_BADGES_IO_COM       = 'test@badges-io.com';
    const EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM   = 'myEmail@badges-io.com';
    const USERNAME_EXISTS_VALID_BADGES_USER     = 'badgesUser';
    const USERNAME_NOT_EXISTS_VALID_BADGES_USER = 'userBadges';
    const PASSWORD_VALID_BE_FREE                = 'B3FR33';

    /**
     * @test
     */
    public function emailAlreadyExistsShouldThrowExceptionEmailAlreadyExistsStatusCode()
    {
        try {
            $commandHandler = $this->buildCommandHandler($this->buildDefaultUserRepository());
            $commandHandler->handle(
                $this->buildCommand(
                    static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $this->thisTestFails();
        } catch (InvalidSignUpCommandHandlerException $invalidSignUpCommandHandlerException) {
            $this->assertEquals(
                InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS,
                $invalidSignUpCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function usernameAlreadyExistsShouldThrowExceptionEmailAlreadyExistsStatusCode()
    {
        try {
            $commandHandler = $this->buildCommandHandler($this->buildDefaultUserRepository());
            $commandHandler->handle(
                $this->buildCommand(
                    static::EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $this->thisTestFails();
        } catch (InvalidSignUpCommandHandlerException $invalidSignUpCommandHandlerException) {
            $this->assertEquals(
                InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS,
                $invalidSignUpCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenCheckEmailShouldThrowExceptionUserNotCreatedException()
    {
        try {
            $commandHandler = $this->buildCommandHandler(
                $this->buildUserExceptionRepository(
                    FakeUserRepositoryThrownException::FIND_BY_EMAIL_METHOD_THROW_EXCEPTION,
                    static::USER_ID,
                    static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $commandHandler->handle(
                $this->buildCommand(
                    static::EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_NOT_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $this->thisTestFails();
        } catch (InvalidSignUpCommandHandlerException $invalidSignUpCommandHandlerException) {
            $this->assertEquals(
                InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED,
                $invalidSignUpCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenCheckUsernameShouldThrowExceptionUserNotCreatedException()
    {
        try {
            $commandHandler = $this->buildCommandHandler(
                $this->buildUserExceptionRepository(
                    FakeUserRepositoryThrownException::FIND_BY_USER_NAME_METHOD_THROW_EXCEPTION,
                    static::USER_ID,
                    static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $commandHandler->handle(
                $this->buildCommand(
                    static::EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_NOT_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $this->thisTestFails();
        } catch (InvalidSignUpCommandHandlerException $invalidSignUpCommandHandlerException) {
            $this->assertEquals(
                InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED,
                $invalidSignUpCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenTryToPersistShouldThrowExceptionUserNotCreatedException()
    {
        try {
            $commandHandler = $this->buildCommandHandler(
                $this->buildUserExceptionRepository(
                    FakeUserRepositoryThrownException::PERSIST_METHOD_THROW_EXCEPTION,
                    static::USER_ID,
                    static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $commandHandler->handle(
                $this->buildCommand(
                    static::EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_NOT_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $this->thisTestFails();
        } catch (InvalidSignUpCommandHandlerException $invalidSignUpCommandHandlerException) {
            $this->assertEquals(
                InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED,
                $invalidSignUpCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function userNotExistsShouldPersistAndReturnUserInfo()
    {
        $userRepository = $this->buildUserRepository(
            static::USER_ID,
            static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
            static::USERNAME_EXISTS_VALID_BADGES_USER,
            static::PASSWORD_VALID_BE_FREE
        );
        $commandHandler = $this->buildCommandHandler($userRepository);

        $command = $this->buildCommand(
            static::EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM,
            static::USERNAME_NOT_EXISTS_VALID_BADGES_USER,
            static::PASSWORD_VALID_BE_FREE
        );

        /** @var User $userResource */
        $userResource = $commandHandler->handle($command);
        $newUser = $userRepository->findByEmail($command->email());

        $this->assertTrue(
            $newUser->email() === $command->email()
            && $command->email() === $userResource->email()
        );
    }

    /**
     * @param $email
     * @param $userName
     * @param $passWord
     *
     * @return SignUpCommand
     */
    private function buildCommand($email, $userName, $passWord)
    {
        return new SignUpCommand($email, $userName, $passWord);
    }

    /**
     * @param UserRepository $userRepository
     *
     * @return SignUpCommandHandler
     */
    private function buildCommandHandler(UserRepository $userRepository)
    {
        return new SignUpCommandHandler(
            $userRepository,
            $this->buildUserDataTransformer(),
            $this->buildIdGenerator(),
            $this->buildPasswordCipher()
        );
    }

    /**
     * @param int $methodException
     * @param string $id
     * @param string $email
     * @param string $userName
     * @param string $passWord
     *
     * @return UserRepository
     */
    private function buildUserExceptionRepository($methodException, $id, $email, $userName, $passWord)
    {
        return new FakeUserRepositoryThrownException(
            [FakeUserBuilder::build($id, $email, $userName, $passWord)],
            $methodException
        );
    }

    /**
     * @return UserRepository
     */
    private function buildDefaultUserRepository()
    {
        return $this->buildUserRepository(
            static::USER_ID,
            static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
            static::USERNAME_EXISTS_VALID_BADGES_USER,
            static::PASSWORD_VALID_BE_FREE
        );
    }

    /**
     * @param string $id
     * @param string $email
     * @param string $userName
     * @param string $passWord
     *
     * @return UserRepository
     */
    private function buildUserRepository($id, $email, $userName, $passWord)
    {
        return new InMemoryUserRepository([FakeUserBuilder::build($id, $email, $userName, $passWord)]);
    }

    /**
     * @return UserDataTransformer
     */
    private function buildUserDataTransformer()
    {
        return new UserNoOpDataTransformer();
    }

    /**
     * @return IdGenerator
     */
    private function buildIdGenerator()
    {
        return new FakeIdGenerator();
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }

    /**
     * @return PasswordCipher
     */
    private function buildPasswordCipher()
    {
        return new FakePasswordCipher();
    }
}
