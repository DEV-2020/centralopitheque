<?php

namespace App\Constants;

final class UserRoles
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SHOP = 'ROLE_SHOP';

    const ROLES = [
        self::ROLE_ADMIN => self::ROLE_ADMIN,
        self::ROLE_SHOP => self::ROLE_SHOP,
    ];
}