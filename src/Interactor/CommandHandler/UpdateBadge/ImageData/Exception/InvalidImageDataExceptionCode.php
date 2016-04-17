<?php

namespace Interactor\CommandHandler\UpdateBadge\ImageData\Exception;

class InvalidImageDataExceptionCode
{
    const STATUS_CODE_NAME_NOT_PROVIDED             = -1;
    const MESSAGE_CODE_NAME_NOT_PROVIDED            = 'Name not provided';
    const STATUS_CODE_NAME_NOT_VALID_PROVIDED       = -2;
    const MESSAGE_CODE_NAME_NOT_VALID_PROVIDED      = 'Name not valid provided';
    const STATUS_CODE_WIDTH_NOT_PROVIDED            = -3;
    const MESSAGE_CODE_WIDTH_NOT_PROVIDED           = 'Width not provided';
    const STATUS_CODE_WIDTH_NOT_VALID_PROVIDED      = -4;
    const MESSAGE_CODE_WIDTH_NOT_VALID_PROVIDED     = 'Width not valid provided';
    const STATUS_CODE_HEIGHT_NOT_PROVIDED           = -5;
    const MESSAGE_CODE_HEIGHT_NOT_PROVIDED          = 'Height not provided';
    const STATUS_CODE_HEIGHT_NOT_VALID_PROVIDED     = -6;
    const MESSAGE_CODE_HEIGHT_NOT_VALID_PROVIDED    = 'Height not provided';
    const STATUS_CODE_FORMAT_NOT_PROVIDED           = -7;
    const MESSAGE_CODE_FORMAT_NOT_PROVIDED          = 'Format not provided';
    const STATUS_CODE_FORMAT_NOT_VALID_PROVIDED     = -8;
    const MESSAGE_CODE_FORMAT_NOT_VALID_PROVIDED    = 'Format not valid provided';
    const STATUS_CODE_PATH_NOT_PROVIDED             = -9;
    const MESSAGE_CODE_PATH_NOT_PROVIDED            = 'Path not provided';
    const STATUS_CODE_PATH_NOT_VALID_PROVIDED       = -10;
    const MESSAGE_CODE_PATH_NOT_VALID_PROVIDED      = 'Path not valid provided';
}
