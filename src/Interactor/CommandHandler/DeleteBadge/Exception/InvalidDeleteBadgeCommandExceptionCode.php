<?php

namespace Interactor\CommandHandler\DeleteBadge\Exception;

class InvalidDeleteBadgeCommandExceptionCode
{
    const STATUS_CODE_BADGE_ID_NOT_PROVIDED          = -1;
    const MESSAGE_CODE_BADGE_ID_NOT_PROVIDED         = 'Badge Id Not Provided';
    const STATUS_CODE_BADGE_ID_NOT_VALID_PROVIDED    = -2;
    const MESSAGE_CODE_BADGE_ID_NOT_VALID_PROVIDED   = 'Badge Id Not Valid Provided';
    const STATUS_CODE_TENANT_ID_NOT_PROVIDED         = -3;
    const MESSAGE_CODE_TENANT_ID_NOT_PROVIDED        = 'Tenant Id Not Provided';
    const STATUS_CODE_TENANT_ID_NOT_VALID_PROVIDED   = -4;
    const MESSAGE_CODE_TENANT_ID_NOT_VALID_PROVIDED  = 'Tenant Id Not Valid Provided';
}
