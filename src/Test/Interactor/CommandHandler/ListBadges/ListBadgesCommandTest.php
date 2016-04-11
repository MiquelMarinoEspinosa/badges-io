<?php

namespace Test\Interactor\CommandHandler\ListBadges;

use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandExceptionCode;
use Interactor\CommandHandler\ListBadges\ListBadgesCommand;

class ListBadgesCommandTest extends \PHPUnit_Framework_TestCase
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
    public function commandWithoutUserIdProvidedShouldThrownExceptionBadgeIdNotProvidedStatusCode()
    {
        try {
            $aNullUserId = null;
            $this->buildListBadgesCommand($aNullUserId);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandException $invalidListBadgesCommandException) {
            $this->assertEquals(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED,
                $invalidListBadgesCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidFormatIdProvidedShouldThrownExceptionBadgeIdNotValidProvidedStatusCode()
    {
        try {
            $this->buildListBadgesCommand(static::NOT_VALID_FORMAT_USER_ID_INTEGER);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandException $invalidListBadgesCommandException) {
            $this->assertEquals(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED,
                $invalidListBadgesCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithNotValidIdProvidedShouldThrownExceptionBadgeIdNotValidProvidedStatusCode()
    {
        try {
            $this->buildListBadgesCommand(static::NOT_VALID_USER_ID_EMPTY);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandException $invalidListBadgesCommandException) {
            $this->assertEquals(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED,
                $invalidListBadgesCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithAllTheParamsValidShouldReturnTheCommand()
    {
        $command = $this->buildListBadgesCommand(static::VALID_USER_ID_4321);

        $this->assertTrue($command->userId() === static::VALID_USER_ID_4321);
    }

    /**
     * @param string $userId
     *
     * @return ListBadgesCommand
     */
    private function buildListBadgesCommand($userId)
    {
        return new ListBadgesCommand($userId);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
