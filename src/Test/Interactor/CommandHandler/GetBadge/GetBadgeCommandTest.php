<?php

namespace Test\Interactor\CommandHandler\GetBadge;

use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandException;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandExceptionCode;
use Interactor\CommandHandler\GetBadge\GetBadgeCommand;

class GetBadgeCommandTest extends \PHPUnit_Framework_TestCase
{
    const NOT_VALID_FORMAT_BADGE_ID_INTEGER  = 1;
    const NOT_VALID_BADGE_ID_EMPTY           = ' ';
    const VALID_BADGE_ID_1234                = '1234';
    const NOT_VALID_FORMAT_USER_ID_INTEGER   = 2;
    const NOT_VALID_USER_ID_EMPTY            = ' ';
    const VALID_USER_ID_4321                 = '4321';

    /**
     * @test
     */
    public function commandWithoutBadgeIdProvidedShouldThrownExceptionBadgeIdNotProvidedStatusCode()
    {
        try {
            $aNullBadgeId  = null;
            $aNullUserId = null;
            $this->buildGetBadgeCommand($aNullBadgeId, $aNullUserId);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandException $invalidGetBadgeCommandException) {
            $this->assertEquals(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_PROVIDED,
                $invalidGetBadgeCommandException->code()
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
            $this->buildGetBadgeCommand(static::NOT_VALID_FORMAT_BADGE_ID_INTEGER, $aNullUserId);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandException $invalidGetBadgeCommandException) {
            $this->assertEquals(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED,
                $invalidGetBadgeCommandException->code()
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
            $this->buildGetBadgeCommand(static::NOT_VALID_BADGE_ID_EMPTY, $aNullUserId);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandException $invalidGetBadgeCommandException) {
            $this->assertEquals(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED,
                $invalidGetBadgeCommandException->code()
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
            $this->buildGetBadgeCommand(static::VALID_BADGE_ID_1234, $aNullUserId);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandException $invalidGetBadgeCommandException) {
            $this->assertEquals(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED,
                $invalidGetBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidFormatIdProvidedShouldThrownExceptionBadgeIdNotValidProvidedStatusCode()
    {
        try {
            $this->buildGetBadgeCommand(static::VALID_BADGE_ID_1234, static::NOT_VALID_FORMAT_USER_ID_INTEGER);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandException $invalidGetBadgeCommandException) {
            $this->assertEquals(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED,
                $invalidGetBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidIdProvidedShouldThrownExceptionBadgeIdNotValidProvidedStatusCode()
    {
        try {
            $this->buildGetBadgeCommand(static::VALID_BADGE_ID_1234, static::NOT_VALID_USER_ID_EMPTY);
            $this->thisTestFails();
        } catch (InvalidGetBadgeCommandException $invalidGetBadgeCommandException) {
            $this->assertEquals(
                InvalidGetBadgeCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED,
                $invalidGetBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithAllTheParamsValidShouldReturnTheCommand()
    {
        $command = $this->buildGetBadgeCommand(static::VALID_BADGE_ID_1234, static::VALID_USER_ID_4321);

        $this->assertTrue($command->badgeId() === static::VALID_BADGE_ID_1234
                          && $command->userId() === static::VALID_USER_ID_4321);
    }

    /**
     * @param string $badgeId
     * @param string $userId
     *
     * @return GetBadgeCommand
     */
    private function buildGetBadgeCommand($badgeId, $userId)
    {
        return new GetBadgeCommand($badgeId, $userId);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
