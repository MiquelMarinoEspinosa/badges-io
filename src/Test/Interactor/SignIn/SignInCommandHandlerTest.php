<?php

namespace Test\Interactor\SignIn;

use Domain\User\User;
use Domain\User\UserIdGenerator;
use Domain\User\UserRepository;
use Infrastructure\DataTransformer\Domain\UserNoOpDataTransformer;
use Infrastructure\InMemory\InMemoryUserRepository;
use Interactor\SignIn\Exception\InvalidSignInCommandHandlerException;
use Interactor\SignIn\SignInCommand;
use Interactor\SignIn\SignInCommandHandler;
use Test\Domain\User\FakeUserBuilder;
use Test\Domain\User\FakeUserIdGenerator;

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
    public function emailAlreadyExistsShouldThrowExceptionEmailAlreadyExistsCode()
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
                InvalidSignInCommandHandlerException::STATUS_CODE_EMAIL_ALREADY_EXISTS,
                $invalidSignInCommandHandlerException->code()
            );
        }
    }

    /**
     * @test
     */
    public function userNameAlreadyExistsShouldThrowExceptionEmailAlreadyExistsCode()
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
                InvalidSignInCommandHandlerException::STATUS_CODE_USERNAME_ALREADY_EXISTS,
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
            $this->buildUserIdGenerator()
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
     * @return UserNoOpDataTransformer
     */
    private function buildUserDataTransformer()
    {
        return new UserNoOpDataTransformer();
    }

    /**
     * @return UserIdGenerator
     */
    private function buildUserIdGenerator()
    {
        return new FakeUserIdGenerator();
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
