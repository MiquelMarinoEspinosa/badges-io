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
    const NOT_VALID_FORMAT_TENANT_ID_INTEGER = 2;
    const NOT_VALID_TENANT_ID_EMPTY          = ' ';
    const VALID_TENANT_ID_4321               = '4321';

    /**
     * @test
     */
    public function commandWithoutTenantIdProvidedShouldThrownExceptionBadgeIdNotProvidedStatusCode()
    {
        try {
            $aNullTenantId = null;
            $this->buildListBadgesCommand($aNullTenantId);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandException $invalidListBadgesCommandException) {
            $this->assertEquals(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_PROVIDED,
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
            $this->buildListBadgesCommand(static::NOT_VALID_FORMAT_TENANT_ID_INTEGER);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandException $invalidListBadgesCommandException) {
            $this->assertEquals(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED,
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
            $this->buildListBadgesCommand(static::NOT_VALID_TENANT_ID_EMPTY);
            $this->thisTestFails();
        } catch (InvalidListBadgesCommandException $invalidListBadgesCommandException) {
            $this->assertEquals(
                InvalidListBadgesCommandExceptionCode::STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED,
                $invalidListBadgesCommandException->code()
            );
        }
    }

    /**
     * @test
     */
    public function commandWithAllTheParamsValidShouldReturnTheCommand()
    {
        $command = $this->buildListBadgesCommand(static::VALID_TENANT_ID_4321);

        $this->assertTrue($command->tenantId() === static::VALID_TENANT_ID_4321);
    }

    /**
     * @param string $tenantId
     *
     * @return ListBadgesCommand
     */
    private function buildListBadgesCommand($tenantId)
    {
        return new ListBadgesCommand($tenantId);
    }

    private function thisTestFails()
    {
        $this->assertTrue(false);
    }
}
