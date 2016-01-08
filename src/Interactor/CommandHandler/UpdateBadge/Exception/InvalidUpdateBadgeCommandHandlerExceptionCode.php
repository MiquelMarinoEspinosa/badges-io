<?php

namespace Interactor\CommandHandler\UpdateBadge\Exception;

class InvalidUpdateBadgeCommandHandlerExceptionCode
{
    const STATUS_CODE_BADGE_NOT_FOUND       = -1;
    const MESSAGE_CODE_BADGE_NOT_FOUND      = 'Badge not found';
    const STATUS_CODE_TENANT_FORBIDDEN      = -2;
    const MESSAGE_CODE_TENANT_FORBIDDEN     = 'Tenant forbidden';
    const STATUS_CODE_BADGE_NOT_UPDATED     = -3;
    const MESSAGE_CODE_BADGE_NOT_UPDATED    = 'Badge not created';
    const STATUS_CODE_TENANT_NOT_FOUND      = -4;
    const MESSAGE_CODE_TENANT_NOT_FOUND     = 'Tenant not found';
}
