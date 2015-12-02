<?php

namespace Test\Interactor\SignIn;

use Interactor\SignIn\Exception\InvalidSignInCommandException;
use Interactor\SignIn\SignInCommand;

class SignInCommandTest extends \PHPUnit_Framework_TestCase
{
    const EMAIL_NOT_VALID_TEST              = 'test';
    const EMAIL_VALID_TEST_BADGES_IO_COM    = 'test@badges-io.com';
    const USERNAME_NOT_VALID_EMPTY          = '';
    const USERNAME_VALID_BADGES_USER        = 'badgesUser';
    const PASSWORD_NOT_VALID_EMPTY          = '';
    const PASSWORD_VALID_BE_FREE            = 'B3FR33';

    /**
     * @test
     */
    public function commandWithoutEmailShouldThrowInvalidCommandExceptionWithEmailNotProvidedStatus()
    {
        try {
            $aNullEmail = null;
            $aNullUserName = null;
            $aNullPassWord = null;
            $this->buildCommand($aNullEmail, $aNullUserName, $aNullPassWord);
            $this->thisTestFails();
        } catch (InvalidSignInCommandException $invalidCommandException) {
            $this->assertEquals(
                InvalidSignInCommandException::STATUS_CODE_EMAIL_NOT_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidEmailShouldThrowInvalidCommandExceptionWithEmailNotValidProvidedStatus()
    {
        try {
            $aNullUserName = null;
            $aNullPassWord = null;
            $this->buildCommand(static::EMAIL_NOT_VALID_TEST, $aNullUserName, $aNullPassWord);
            $this->thisTestFails();
        } catch (InvalidSignInCommandException $invalidCommandException) {
            $this->assertEquals(
                InvalidSignInCommandException::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithoutUserNameShouldThrowInvalidCommandExceptionWithUsernameNotProvidedStatus()
    {
        try {
            $aNullUserName = null;
            $aNullPassWord = null;
            $this->buildCommand(static::EMAIL_VALID_TEST_BADGES_IO_COM, $aNullUserName, $aNullPassWord);
            $this->thisTestFails();
        } catch (InvalidSignInCommandException $invalidCommandException) {
            $this->assertEquals(
                InvalidSignInCommandException::STATUS_CODE_USERNAME_NOT_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidUserNameShouldThrowInvalidCommandExceptionWithUserNameNotValidProvidedStatus()
    {
        try {
            $aNullPassWord = null;
            $this->buildCommand(
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                static::USERNAME_NOT_VALID_EMPTY,
                $aNullPassWord
            );
            $this->thisTestFails();
        } catch (InvalidSignInCommandException $invalidCommandException) {
            $this->assertEquals(
                InvalidSignInCommandException::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithoutPassWordShouldThrowInvalidCommandExceptionWithPassWordNotProvidedStatus()
    {
        try {
            $aNullPassWord = null;
            $this->buildCommand(
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                static::USERNAME_VALID_BADGES_USER,
                $aNullPassWord
            );
            $this->thisTestFails();
        } catch (InvalidSignInCommandException $invalidCommandException) {
            $this->assertEquals(
                InvalidSignInCommandException::STATUS_CODE_PASSWORD_NOT_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidPassWordShouldThrowInvalidCommandExceptionWithPassWordNotValidProvidedStatus()
    {
        try {
            $this->buildCommand(
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                static::USERNAME_VALID_BADGES_USER,
                static::PASSWORD_NOT_VALID_EMPTY
            );
        } catch (InvalidSignInCommandException $invalidCommandException) {
            $this->assertEquals(
                InvalidSignInCommandException::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithAllTheParamsValidShouldReturnTheCommand()
    {
        $command = $this->buildCommand(
            static::EMAIL_VALID_TEST_BADGES_IO_COM,
            static::USERNAME_VALID_BADGES_USER,
            static::PASSWORD_VALID_BE_FREE
        );

        $this->assertTrue(
            $command->email() === static::EMAIL_VALID_TEST_BADGES_IO_COM
            && $command->userName() === static::USERNAME_VALID_BADGES_USER
            && $command->passWord() === static::PASSWORD_VALID_BE_FREE
        );
    }

    /**
     * @param string $email
     * @param string $userName
     * @param string $passWord
     *
     * @return SignInCommand
     */
    private function buildCommand($email, $userName, $passWord)
    {
        return new SignInCommand($email, $userName, $passWord);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
