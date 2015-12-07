<?php

namespace Test\Domain\Tenant;

use Domain\Tenant\Tenant;

class FakeTenantBuilder extends Tenant
{
    /**
     * @param string $id
     * @param string $email
     * @param string $userName
     * @param string $passWord
     *
     * @return Tenant
     */
    public static function build($id, $email, $userName, $passWord)
    {
        return new self($id, $email, $userName, $passWord);
    }
}
