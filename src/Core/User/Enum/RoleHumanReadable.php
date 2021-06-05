<?php

declare(strict_types=1);

namespace App\Core\User\Enum;

use App\Core\Common\Enum\AbstractEnum;

final class RoleHumanReadable extends AbstractEnum
{
    public const ADMIN = 'Администратор';
    public const USER  = 'Пользователь';
    public const USER_AUTH = 'Авторизованный пользователь';
    public const AD_MODERATOR  = 'Модератор объявлений';
    public const OPERATOR  = 'Оператор';
}
