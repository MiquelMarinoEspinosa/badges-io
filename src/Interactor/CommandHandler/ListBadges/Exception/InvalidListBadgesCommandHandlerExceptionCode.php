<?php

namespace Interactor\CommandHandler\ListBadges\Exception;

class InvalidListBadgesCommandHandlerExceptionCode
{
    const STATUS_CODE_BADGES_NOT_FOUND   = -1;
    const MESSAGE_CODE_BADGE_NOT_FOUND  = 'Badge Not Found';
    const STATUS_CODE_TENANT_NOT_FOUND  = -2;
    const MESSAGE_CODE_TENANT_NOT_FOUND = 'Tenant Not Valid';
}
