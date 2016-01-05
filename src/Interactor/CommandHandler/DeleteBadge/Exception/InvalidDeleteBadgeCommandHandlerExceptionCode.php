<?php

namespace Interactor\CommandHandler\DeleteBadge\Exception;

class InvalidDeleteBadgeCommandHandlerExceptionCode
{
    const STATUS_CODE_BADGE_NOT_FOUND    = -1;
    const MESSAGE_CODE_BADGE_NOT_FOUND   = 'Badge Not Found';
    const STATUS_CODE_TENANT_NOT_VALID   = -2;
    const MESSAGE_CODE_TENANT_NOT_VALID  = 'Tenant Not Valid';
    const STATUS_CODE_BADGE_NOT_REMOVED  = -3;
    const MESSAGE_CODE_BADGE_NOT_REMOVED = 'Badge Not Removed';
}
