<?php

declare(strict_types=1);

namespace App\Core\Books\Enum;

use App\Core\Common\Enum\AbstractEnum;

class PermissionBooks extends AbstractEnum
{
    public const BOOKS_PUBLISH_CREATE = 'ROLE_BOOKS_PUBLISH_CREATE';
    public const BOOKS_SHOW           = 'ROLE_BOOKS_SHOW';
    public const BOOKS_INDEX          = 'ROLE_BOOKS_INDEX';
    public const BOOKS_CREATE         = 'ROLE_BOOKS_CREATE';
    public const BOOKS_UPDATE         = 'ROLE_BOOKS_UPDATE';
    public const BOOKS_DELETE         = 'ROLE_BOOKS_DELETE';
    public const BOOKS_VALIDATION     = 'ROLE_BOOKS_VALIDATION';
}