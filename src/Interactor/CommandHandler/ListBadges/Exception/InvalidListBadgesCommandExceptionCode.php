<?php

namespace Interactor\CommandHandler\ListBadges\Exception;

class InvalidListBadgesCommandExceptionCode
{
    const STATUS_CODE_TENANT_ID_NOT_PROVIDED         = -1;
    const MESSAGE_CODE_TENANT_ID_NOT_PROVIDED        = 'Tenant Id Not Provided';
    const STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED   = -2;
    const MESSAGE_CODE_TENANT_ID_NOT_VALID_PROVIDED  = 'Tenant Id Not Valid Provided';
}
