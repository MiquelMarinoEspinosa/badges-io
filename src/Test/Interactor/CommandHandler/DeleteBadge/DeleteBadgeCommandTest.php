<?php

namespace Test\Interactor\CommandHandler\DeleteBadge;

use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandException;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandExceptionCode;
use Interactor\CommandHandler\DeleteBadge\DeleteBadgeCommand;

class DeleteBadgeCommandTest extends \PHPUnit_Framework_TestCase
{
    const NOT_VALID_FORMAT_BADGE_ID_INTEGER = 1;
    const NOT_VALID_BADGE_ID_EMPTY          = ' ';
    const VALID_BADGE_ID_1234               = '1234';
    const NOT_VALID_FORMAT_USER_ID_INTEGER  = 2;
    const NOT_VALID_USER_ID_EMPTY           = ' ';
    const VALID_USER_ID_4321                = '4321';

    /**
     * @test
     */
    public function commandWithoutBadgeIdProvidedShouldThrownExceptionBadgeIdNotProvidedStatusCode()
    {
        try {
            $aNullBadgeId  = null;
            $aNullUserId = null;
            $this->buildDeleteBadgeCommand($aNullBadgeId, $aNullUserId);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_PROVIDED,
                $invalidDeleteBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidBadgeIdFormatProvidedShouldThrownExceptionBadgeIdNotValidProvidedStatusCode()
    {
        try {
            $aNullUserId = null;
            $this->buildDeleteBadgeCommand(static::NOT_VALID_FORMAT_BADGE_ID_INTEGER, $aNullUserId);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED,
                $invalidDeleteBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidBadgeIdProvidedShouldThrownExceptionBadgeIdNotValidProvidedStatusCode()
    {
        try {
            $aNullUserId = null;
            $this->buildDeleteBadgeCommand(static::NOT_VALID_BADGE_ID_EMPTY, $aNullUserId);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED,
                $invalidDeleteBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithoutUserIdProvidedShouldThrownExceptionBadgeIdNotProvidedStatusCode()
    {
        try {
            $aNullUserId = null;
            $this->buildDeleteBadgeCommand(static::VALID_BADGE_ID_1234, $aNullUserId);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED,
                $invalidDeleteBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidFormatIdProvidedShouldThrownExceptionBadgeIdNotValidProvidedStatusCode()
    {
        try {
            $this->buildDeleteBadgeCommand(static::VALID_BADGE_ID_1234, static::NOT_VALID_FORMAT_USER_ID_INTEGER);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED,
                $invalidDeleteBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidIdProvidedShouldThrownExceptionBadgeIdNotValidProvidedStatusCode()
    {
        try {
            $this->buildDeleteBadgeCommand(static::VALID_BADGE_ID_1234, static::NOT_VALID_USER_ID_EMPTY);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED,
                $invalidDeleteBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithAllTheParamsValidShouldReturnTheCommand()
    {
        $command = $this->buildDeleteBadgeCommand(static::VALID_BADGE_ID_1234, static::VALID_USER_ID_4321);

        $this->assertTrue(
            $command->badgeId() === static::VALID_BADGE_ID_1234
            && $command->userId() === static::VALID_USER_ID_4321
        );
    }

    /**
     * @param string $badgeId
     * @param string $userId
     *
     * @return DeleteBadgeCommand
     */
    private function buildDeleteBadgeCommand($badgeId, $userId)
    {
        return new DeleteBadgeCommand($badgeId, $userId);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
