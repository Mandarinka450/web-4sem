<?php

declare(strict_types=1);

namespace App\Core\User\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Role extends AbstractEnum
{
    public const ADMIN = 'ROLE_ADMIN';
    public const USER  = 'ROLE_USER';
    public const OPERATOR  = 'ROLE_OPERATOR';
    public const BOOKS_MODERATOR  = 'ROLE_BOOKS_MODERATOR';
    public const USER_AUTH  = 'ROLE_USER_AUTH';
}
