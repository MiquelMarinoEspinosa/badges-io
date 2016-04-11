<?php

namespace Test\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\Exception\InvalidBadgeException;
use Domain\Entity\Badge\Exception\InvalidBadgeExceptionCode;
use Domain\Entity\Image\Image;
use Domain\Entity\User\User;
use Test\Domain\Entity\Image\FakeImageBuilder;
use Test\Domain\Entity\User\FakeUserBuilder;

class BadgeTest extends \PHPUnit_Framework_TestCase
{
    const ID_NOT_VALID_EMPTY             = ' ';
    const ID_NOT_VALID_INT               = 13;
    const ID_VALID_1234                  = '1234';
    const NAME_NOT_VALID_EMPTY           = ' ';
    const NAME_NOT_VALID_INT             = 12;
    const NAME_VALID_BADGE_NAME          = 'badgeName';
    const DESCRIPTION_NOT_VALID_FLOAT    = 1.4;
    const DESCRIPTION_VALID_EMPTY        = '';
    const IS_MULTI_USER_NOT_VALID_STRING = 'aString';
    const IS_MULTI_USER_VALID_TRUE       = true;
    const IS_MULTI_USER_VALID_FALSE      = false;
    const USER_ID_1234                   = '1234';
    const USER_EMAIL_TEST_BADGES_IO_COM  = 'test@badges-io.com';
    const USER_USERNAME_BADGES_USER      = 'badgesUSer';
    const USER_PASSWORD_BE_FREE          = 'B3FR33';
    const USER_ID_12345                  = '1235';
    const USER_EMAIL_TEST_BADGES_COM     = 'test@badges.com';
    const USER_USERNAME_USER             = 'user';
    const USER_PASSWORD_BE_COOL          = 'B3C10L';
    const IMAGE_ID_4321                  = '4321';
    const IMAGE_NAME_FLOWER              = 'flower';
    const IMAGE_WIDTH_4                  = 4;
    const IMAGE_HEIGHT_5                 = 5;
    const IMAGE_FORMAT_JPEG              = 'jpeg';
    const USER_NOT_VALID_INT_1           = 1;

    /**
     * @test
     */
    public function notIdProvidedShouldThrownExceptionIdNotProvidedStatusCode()
    {
        try {
            $aNullId          = null;
            $aNullName        = null;
            $aNullDescription = null;
            $aNullIsMultiUser = null;

            $this->buildBadge(
                $aNullId,
                $aNullName,
                $aNullDescription,
                $aNullIsMultiUser
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidIdTypeProvidedShouldThrownExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullName        = null;
            $aNullDescription = null;
            $aNullIsMultiUser = null;

            $this->buildBadge(
                static::ID_NOT_VALID_INT,
                $aNullName,
                $aNullDescription,
                $aNullIsMultiUser
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidIdProvidedShouldThrownExceptionIdNotValidProvidedStatusCode()
    {
        try {
            $aNullName        = null;
            $aNullDescription = null;
            $aNullIsMultiUser = null;

            $this->buildBadge(
                static::ID_NOT_VALID_EMPTY,
                $aNullName,
                $aNullDescription,
                $aNullIsMultiUser
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notNameProvidedShouldThrownExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullName        = null;
            $aNullDescription = null;
            $aNullIsMultiUser = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                $aNullName,
                $aNullDescription,
                $aNullIsMultiUser
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidNameProvidedShouldThrownExceptionNameNotProvidedStatusCode()
    {
        try {
            $aNullDescription = null;
            $aNullIsMultiUser = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_NOT_VALID_EMPTY,
                $aNullDescription,
                $aNullIsMultiUser
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notDescriptionProvidedShouldThrownExceptionDescriptionNotProvidedStatusCode()
    {
        try {
            $aNullDescription = null;
            $aNullIsMultiUser = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                $aNullDescription,
                $aNullIsMultiUser
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidDescriptionTypeProvidedShouldThrownExceptionDescriptionNotValidProvidedStatusCode()
    {
        try {
            $aNullIsMultiUser = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_NOT_VALID_FLOAT,
                $aNullIsMultiUser
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notIsMultiUserProvidedShouldThrownExceptionIsMultiUserNotProvidedStatusCode()
    {
        try {
            $aNullIsMultiUser = null;

            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_VALID_EMPTY,
                $aNullIsMultiUser
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function notValidIsMultiUserTypeProvidedShouldThrownExceptionIsMultiUserNotValidProvidedStatusCode()
    {
        try {
            $this->buildBadge(
                static::ID_VALID_1234,
                static::NAME_VALID_BADGE_NAME,
                static::DESCRIPTION_VALID_EMPTY,
                static::IS_MULTI_USER_NOT_VALID_STRING
            );
            $this->thisTestFails();
        } catch (InvalidBadgeException $invalidBadgeException) {
            $this->assertEquals(
                InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED,
                $invalidBadgeException->code()
            );
        }
    }

    /**
     * @test
     */
    public function validParametersShouldReturnTheBadge()
    {
        $badge= $this->buildBadge(
            static::ID_VALID_1234,
            static::NAME_VALID_BADGE_NAME,
            static::DESCRIPTION_VALID_EMPTY,
            static::IS_MULTI_USER_VALID_TRUE
        );

        $this->assertTrue(
            $badge->id() === static::ID_VALID_1234
            && $badge->name() === static::NAME_VALID_BADGE_NAME
            && $badge->description() === static::DESCRIPTION_VALID_EMPTY
            && $badge->isMultiUser() === static::IS_MULTI_USER_VALID_TRUE
            && $badge->user()  instanceof User
            && $badge->image() instanceof Image
        );
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param boolean $isMultiUser
     *
     * @return Badge
     */
    private function buildBadge(
        $id,
        $name,
        $description,
        $isMultiUser
    ) {
        return new Badge(
            $id,
            $name,
            $description,
            $isMultiUser,
            $this->buildUser(),
            $this->buildImage()
        );
    }

    /**
     * @return User
     */
    private function buildUser()
    {
        return FakeUserBuilder::build(
            static::USER_ID_1234,
            static::USER_EMAIL_TEST_BADGES_IO_COM,
            static::USER_USERNAME_BADGES_USER,
            static::USER_PASSWORD_BE_FREE
        )
        ;
    }

    /**
     * @return Image
     */
    private function buildImage()
    {
        return FakeImageBuilder::build(
            static::IMAGE_ID_4321,
            static::IMAGE_NAME_FLOWER,
            static::IMAGE_WIDTH_4,
            static::IMAGE_HEIGHT_5,
            static::IMAGE_FORMAT_JPEG
        );
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
