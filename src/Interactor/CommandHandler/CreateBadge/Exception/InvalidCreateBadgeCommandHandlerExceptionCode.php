<?php

namespace Interactor\CommandHandler\CreateBadge\Exception;

class InvalidCreateBadgeCommandHandlerExceptionCode
{
    const STATUS_CODE_BADGE_NOT_CREATED     = -1;
    const MESSAGE_CODE_BADGE_NOT_CREATED    = 'Badge not created';
    const STATUS_CODE_USER_NOT_FOUND        = -2;
    const MESSAGE_CODE_TENANT_NOT_FOUND     = 'Tenant not found';
}
