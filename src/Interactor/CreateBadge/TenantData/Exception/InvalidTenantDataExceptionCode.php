<?php

namespace Interactor\CreateBadge\TenantData\Exception;

use Exception\BaseException;

class InvalidTenantDataExceptionCode extends BaseException
{
    const STATUS_CODE_ID_NOT_PROVIDED           = -1;
    const MESSAGE_CODE_ID_NOT_PROVIDED          = 'Id not provided';
    const STATUS_CODE_ID_NOT_VALID_PROVIDED     = -2;
    const MESSAGE_CODE_ID_NOT_VALID_PROVIDED    = 'Id not provided';
}
