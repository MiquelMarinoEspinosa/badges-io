<?php

namespace Test\Interactor\CommandHandler\DeleteBadge;

use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandException;
use Interactor\CommandHandler\DeleteBadge\Exception\InvalidDeleteBadgeCommandExceptionCode;
use Interactor\CommandHandler\DeleteBadge\DeleteBadgeCommand;

class DeleteBadgeCommandTest extends \PHPUnit_Framework_TestCase
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
            $this->buildDeleteBadgeCommand($aNullBadgeId, $aNullTenantId);
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
            $aNullTenantId = null;
            $this->buildDeleteBadgeCommand(static::NOT_VALID_FORMAT_BADGE_ID_INTEGER, $aNullTenantId);
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
            $aNullTenantId = null;
            $this->buildDeleteBadgeCommand(static::NOT_VALID_BADGE_ID_EMPTY, $aNullTenantId);
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
    public function commandWithoutTenantIdProvidedShouldThrownExceptionBadgeIdNotProvidedStatusCode()
    {
        try {
            $aNullTenantId = null;
            $this->buildDeleteBadgeCommand(static::VALID_BADGE_ID_1234, $aNullTenantId);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_PROVIDED,
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
            $this->buildDeleteBadgeCommand(static::VALID_BADGE_ID_1234, static::NOT_VALID_FORMAT_TENANT_ID_INTEGER);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED,
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
            $this->buildDeleteBadgeCommand(static::VALID_BADGE_ID_1234, static::NOT_VALID_TENANT_ID_EMPTY);
            $this->thisTestFails();
        } catch (InvalidDeleteBadgeCommandException $invalidDeleteBadgeCommandException) {
            $this->assertEquals(
                InvalidDeleteBadgeCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED,
                $invalidDeleteBadgeCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithAllTheParamsValidShouldReturnTheCommand()
    {
        $command = $this->buildDeleteBadgeCommand(static::VALID_BADGE_ID_1234, static::VALID_TENANT_ID_4321);

        $this->assertTrue(
            $command->badgeId() === static::VALID_BADGE_ID_1234
            && $command->tenantId() === static::VALID_TENANT_ID_4321
        );
    }

    /**
     * @param string $badgeId
     * @param string $tenantId
     *
     * @return DeleteBadgeCommand
     */
    private function buildDeleteBadgeCommand($badgeId, $tenantId)
    {
        return new DeleteBadgeCommand($badgeId, $tenantId);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
