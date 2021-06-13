<?php

declare(strict_types=1);

namespace App\Core\Ad\Enum;

use App\Core\Common\Enum\AbstractEnum;

class PermissionAd extends AbstractEnum
{
    public const AD_SHOW           = 'ROLE_AD_SHOW';
    public const AD_INDEX          = 'ROLE_AD_INDEX';
    public const AD_CREATE         = 'ROLE_AD_CREATE';
    public const AD_UPDATE         = 'ROLE_AD_UPDATE';
    public const AD_DELETE         = 'ROLE_AD_DELETE';
    public const AD_VALIDATION     = 'ROLE_AD_VALIDATION';
}