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
    const NOT_VALID_FORMAT_TENANT_ID_INTEGER = 2;
    const NOT_VALID_TENANT_ID_EMPTY          = ' ';
    const VALID_TENANT_ID_4321               = '4321';

    /**
     * @test
     */
    public function commandWithoutBadgeIdProvidedShouldThrownExceptionBadgeIdNotProvidedStatusCode()
    {
        try {
            $aNullBadgeId  = null;
            $aNullTenantId = null;
            $this->buildGetBadgeCommand($aNullBadgeId, $aNullTenantId);
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
            $aNullTenantId = null;
            $this->buildGetBadgeCommand(static::NOT_VALID_FORMAT_BADGE_ID_INTEGER, $aNullTenantId);
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
            $aNullTenantId = null;
            $this->buildGetBadgeCommand(static::NOT_VALID_BADGE_ID_EMPTY, $aNullTenantId);
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
    public function commandWithoutTenantIdProvidedShouldThrownExceptionBadgeIdNotProvidedStatusCode()
    {
        try {
            $aNullTenantId = null;
            $this->buildGetBadgeCommand(static::VALID_BADGE_ID_1234, $aNullTenantId);
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
            $this->buildGetBadgeCommand(static::VALID_BADGE_ID_1234, static::NOT_VALID_FORMAT_TENANT_ID_INTEGER);
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
            $this->buildGetBadgeCommand(static::VALID_BADGE_ID_1234, static::NOT_VALID_TENANT_ID_EMPTY);
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
        $command = $this->buildGetBadgeCommand(static::VALID_BADGE_ID_1234, static::VALID_TENANT_ID_4321);

        $this->assertTrue($command->badgeId() === static::VALID_BADGE_ID_1234
                          && $command->userId() === static::VALID_TENANT_ID_4321);
    }

    /**
     * @param string $badgeId
     * @param string $tenantId
     *
     * @return GetBadgeCommand
     */
    private function buildGetBadgeCommand($badgeId, $tenantId)
    {
        return new GetBadgeCommand($badgeId, $tenantId);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
