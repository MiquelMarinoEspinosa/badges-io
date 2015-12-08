<?php

namespace Test\Interactor\CommandHandler\SignIn;

use Domain\Service\IdGenerator;
use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;
use Domain\Entity\User\UserRepository;
use Infrastructure\DataTransformer\Domain\Entity\User\UserNoOpDataTransformer;
use Infrastructure\InMemory\Domain\Entity\User\InMemoryUserRepository;
use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandHandlerException;
use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandHandlerExceptionCode;
use Interactor\CommandHandler\SignIn\SignInCommand;
use Interactor\CommandHandler\SignIn\SignInCommandHandler;
use Test\Domain\Service\FakeIdGenerator;
use Test\Domain\Entity\User\FakeUserBuilder;
use Test\Domain\Entity\User\FakeUserRepositoryThrownException;

class SignInCommandHandlerTest extends \PHPUnit_Framework_TestCase
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
            $commandHandler = $this->buildCommandHandler(
                $this->buildUserRepository(
                    static::USER_ID,
                    static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $commandHandler->handle(
                $this->buildCommand(
                    static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $this->thisTestFails();
        } catch (InvalidSignInCommandHandlerException $invalidSignInCommandHandlerException) {
            $this->assertEquals(
                InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS,
                $invalidSignInCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function userNameAlreadyExistsShouldThrowExceptionEmailAlreadyExistsStatusCode()
    {
        try {
            $commandHandler = $this->buildCommandHandler(
                $this->buildUserRepository(
                    static::USER_ID,
                    static::EMAIL_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $commandHandler->handle(
                $this->buildCommand(
                    static::EMAIL_NOT_EXISTS_TEST_BADGES_IO_COM,
                    static::USERNAME_EXISTS_VALID_BADGES_USER,
                    static::PASSWORD_VALID_BE_FREE
                )
            );
            $this->thisTestFails();
        } catch (InvalidSignInCommandHandlerException $invalidSignInCommandHandlerException) {
            $this->assertEquals(
                InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS,
                $invalidSignInCommandHandlerException->code()
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
        } catch (InvalidSignInCommandHandlerException $invalidSignInCommandHandlerException) {
            $this->assertEquals(
                InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED,
                $invalidSignInCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function exceptionRepositoryWhenCheckUserNameShouldThrowExceptionUserNotCreatedException()
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
        } catch (InvalidSignInCommandHandlerException $invalidSignInCommandHandlerException) {
            $this->assertEquals(
                InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED,
                $invalidSignInCommandHandlerException->code()
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
        } catch (InvalidSignInCommandHandlerException $invalidSignInCommandHandlerException) {
            $this->assertEquals(
                InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED,
                $invalidSignInCommandHandlerException->code()
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
     * @return SignInCommand
     */
    private function buildCommand($email, $userName, $passWord)
    {
        return new SignInCommand($email, $userName, $passWord);
    }

    /**
     * @param UserRepository $userRepository
     *
     * @return SignInCommandHandler
     */
    private function buildCommandHandler(UserRepository $userRepository)
    {
        return new SignInCommandHandler(
            $userRepository,
            $this->buildUserDataTransformer(),
            $this->buildIdGenerator()
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
}
