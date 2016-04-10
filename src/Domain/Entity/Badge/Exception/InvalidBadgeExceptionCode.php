<?php

namespace Domain\Entity\Badge\Exception;

class InvalidBadgeExceptionCode
{
    const STATUS_CODE_ID_NOT_PROVIDED                       = -1;
    const MESSAGE_CODE_ID_NOT_PROVIDED                      = 'Id not provided';
    const STATUS_CODE_ID_NOT_VALID_PROVIDED                 = -2;
    const MESSAGE_CODE_ID_NOT_VALID_PROVIDED                = 'Id not valid provided';
    const STATUS_CODE_NAME_NOT_PROVIDED                     = -3;
    const MESSAGE_CODE_NAME_NOT_PROVIDED                    = 'Name not provided';
    const STATUS_CODE_NAME_NOT_VALID_PROVIDED               = -4;
    const MESSAGE_CODE_NAME_NOT_VALID_PROVIDED              = 'Name not valid provided';
    const STATUS_CODE_DESCRIPTION_NOT_PROVIDED              = -5;
    const MESSAGE_CODE_DESCRIPTION_NOT_PROVIDED             = 'Description not provided';
    const STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED        = -6;
    const MESSAGE_CODE_DESCRIPTION_NOT_VALID_PROVIDED       = 'Description not valid provided';
    const STATUS_CODE_IS_MULTI_USER_NOT_PROVIDED          = -7;
    const MESSAGE_CODE_IS_MULTI_USER_NOT_PROVIDED         = 'IsMultiTenant not provided';
    const STATUS_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED    = -8;
    const MESSAGE_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED   = 'IsMultiTenant not valid provided';
}
