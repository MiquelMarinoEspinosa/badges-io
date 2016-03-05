<?php

namespace Test\Interactor\CommandHandler\LogIn;

use Interactor\CommandHandler\LogIn\Exception\InvalidLogInCommandException;
use Interactor\CommandHandler\LogIn\Exception\InvalidLogInCommandExceptionCode;
use Interactor\CommandHandler\LogIn\LogInCommand;

class LogInCommandTest extends \PHPUnit_Framework_TestCase
{
    const USER_ID_NOT_VALID_INT_3           = 3;
    const USER_ID_VALID_BADGES_USER         = 'badgesUser';
    const PASSWORD_NOT_VALID_BOOLEAN_TRUE   = true;
    const PASSWORD_VALID_BEFREE             = 'B3Fr33';

    /**
     * @test
     */
    public function commandWithoutUserIdProvidedShouldThrownExceptionUserIdNotProvidedCodeStatus()
    {
        try {
            $aNullUserId    = null;
            $aNullPassWord  = null;
            $this->buildCommand($aNullUserId, $aNullPassWord);

            $this->thisTestFails();
        } catch (InvalidLogInCommandException $invalidLogInCommandException) {
            $this->assertEquals(
                InvalidLogInCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED,
                $invalidLogInCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithUserIdNotValidTypeProvidedShouldThrownExceptionUserIdNotValidProvidedCodeStatus()
    {
        try {
            $aNullPassWord  = null;
            $this->buildCommand(static::USER_ID_NOT_VALID_INT_3, $aNullPassWord);

            $this->thisTestFails();
        } catch (InvalidLogInCommandException $invalidLogInCommandException) {
            $this->assertEquals(
                InvalidLogInCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED,
                $invalidLogInCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithoutPasswordProvidedShouldThrownExceptionPassWordNotProvidedCodeStatus()
    {
        try {
            $aNullPassWord  = null;
            $this->buildCommand(static::USER_ID_VALID_BADGES_USER, $aNullPassWord);

            $this->thisTestFails();
        } catch (InvalidLogInCommandException $invalidLogInCommandException) {
            $this->assertEquals(
                InvalidLogInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED,
                $invalidLogInCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithPasswordNotValidTypeProvidedShouldThrownExceptionPassWordNotValidProvidedCodeStatus()
    {
        try {
            $this->buildCommand(static::USER_ID_VALID_BADGES_USER, static::PASSWORD_NOT_VALID_BOOLEAN_TRUE);

            $this->thisTestFails();
        } catch (InvalidLogInCommandException $invalidLogInCommandException) {
            $this->assertEquals(
                InvalidLogInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED,
                $invalidLogInCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithAllTheParametersValidShouldReturnTheCommand()
    {
        $command = $this->buildCommand(static::USER_ID_VALID_BADGES_USER, static::PASSWORD_VALID_BEFREE);

        $this->assertTrue(
            $command->userId() === static::USER_ID_VALID_BADGES_USER
            && $command->passWord() === static::PASSWORD_VALID_BEFREE
        );
    }

    /**
     * @param string $userId
     * @param string $passWord
     *
     * @return LogInCommand
     */
    private function buildCommand($userId, $passWord)
    {
        return new LogInCommand($userId, $passWord);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
