<?php

namespace Test\Interactor\CommandHandler\SignUp;

use Domain\Entity\User\Exception\InvalidUserException;
use Domain\Entity\User\Exception\InvalidUserExceptionCode;
use Domain\Entity\User\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    const ID_NOT_VALID_INT                  = 1;
    const ID_NOT_VALID_EMPTY                = '';
    const ID_VALID_1234                     = '1234';
    const EMAIL_NOT_VALID_TEST              = 'test';
    const EMAIL_VALID_TEST_BADGES_IO_COM    = 'test@badges-io.com';
    const USERNAME_NOT_VALID_FLOAT          = 2.4;
    const USERNAME_NOT_VALID_EMPTY          = '';
    const USERNAME_VALID_BADGES_USER        = 'badgesUser';
    const PASSWORD_NOT_VALID_INT            = 1;
    const PASSWORD_NOT_VALID_EMPTY          = '';
    const PASSWORD_VALID_BE_FREE            = 'B3FR33';

    /**
     * @test
     */
    public function notIdProvidedShouldThrowInvalidUserExceptionWithIdNotProvidedStatus()
    {
        try {
            $aNullId        = null;
            $aNullEmail     = null;
            $aNullUserName  = null;
            $aNullPassWord  = null;
            $this->buildUser($aNullId, $aNullEmail, $aNullUserName, $aNullPassWord);
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_ID_NOT_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidIdShouldThrowInvalidUserExceptionWithIdNotValidProvidedStatus()
    {
        try {
            $aNullEmail     = null;
            $aNullUserName  = null;
            $aNullPassWord  = null;
            $this->buildUser(static::ID_NOT_VALID_EMPTY, $aNullEmail, $aNullUserName, $aNullPassWord);
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidIdTypeShouldThrowInvalidUserExceptionWithIdNotValidProvidedStatus()
    {
        try {
            $aNullEmail     = null;
            $aNullUserName  = null;
            $aNullPassWord  = null;
            $this->buildUser(static::ID_NOT_VALID_INT, $aNullEmail, $aNullUserName, $aNullPassWord);
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function nullEmailShouldThrowInvalidUserExceptionWithEmailNotProvidedStatus()
    {
        try {
            $aNullEmail     = null;
            $aNullUserName  = null;
            $aNullPassWord  = null;
            $this->buildUser(static::ID_VALID_1234, $aNullEmail, $aNullUserName, $aNullPassWord);
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidEmailShouldThrowInvalidUserExceptionWithEmailNotValidProvidedStatus()
    {
        try {
            $aNullUserName = null;
            $aNullPassWord = null;
            $this->buildUser(static::ID_VALID_1234, static::EMAIL_NOT_VALID_TEST, $aNullUserName, $aNullPassWord);
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function nullUsernameShouldThrowInvalidUserExceptionWithUsernameNotProvidedStatus()
    {
        try {
            $aNullUserName = null;
            $aNullPassWord = null;
            $this->buildUser(
                static::ID_VALID_1234,
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                $aNullUserName,
                $aNullPassWord
            );
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidUsernameShouldThrowInvalidUserExceptionWithUserNameNotValidProvidedStatus()
    {
        try {
            $aNullPassWord = null;
            $this->buildUser(
                static::ID_VALID_1234,
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                static::USERNAME_NOT_VALID_EMPTY,
                $aNullPassWord
            );
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidUsernameTypeShouldThrowInvalidUserExceptionWithUserNameNotValidProvidedStatus()
    {
        try {
            $aNullPassWord = null;
            $this->buildUser(
                static::ID_VALID_1234,
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                static::USERNAME_NOT_VALID_FLOAT,
                $aNullPassWord
            );
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function nullPasswordShouldThrowInvalidUserExceptionWithPassWordNotProvidedStatus()
    {
        try {
            $aNullPassWord = null;
            $this->buildUser(
                static::ID_VALID_1234,
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                static::USERNAME_VALID_BADGES_USER,
                $aNullPassWord
            );
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidPasswordShouldThrowInvalidUserExceptionWithPassWordNotValidProvidedStatus()
    {
        try {
            $this->buildUser(
                static::ID_VALID_1234,
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                static::USERNAME_VALID_BADGES_USER,
                static::PASSWORD_NOT_VALID_EMPTY
            );
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidPasswordTypeShouldThrowInvalidUserExceptionWithPassWordNotValidProvidedStatus()
    {
        try {
            $this->buildUser(
                static::ID_VALID_1234,
                static::EMAIL_VALID_TEST_BADGES_IO_COM,
                static::USERNAME_VALID_BADGES_USER,
                static::PASSWORD_NOT_VALID_INT
            );
            $this->thisTestFails();
        } catch (InvalidUserException $invalidCommandException) {
            $this->assertEquals(
                InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED,
                $invalidCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function validParametersShouldReturnTheUser()
    {
        $user = $this->buildUser(
            static::ID_VALID_1234,
            static::EMAIL_VALID_TEST_BADGES_IO_COM,
            static::USERNAME_VALID_BADGES_USER,
            static::PASSWORD_VALID_BE_FREE
        );

        $this->assertTrue(
            $user->id() === static::ID_VALID_1234
            && $user->email() === static::EMAIL_VALID_TEST_BADGES_IO_COM
            && $user->userName() === static::USERNAME_VALID_BADGES_USER
            && $user->passWord() === static::PASSWORD_VALID_BE_FREE
        );
    }

    /**
     * @param string $id
     * @param string $email
     * @param string $userName
     * @param string $passWord
     *
     * @return User
     */
    private function buildUser($id, $email, $userName, $passWord)
    {
        return new User($id, $email, $userName, $passWord);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
