<?php

declare(strict_types=1);

namespace App\Api\Ad\Dto;

use App\Core\Ad\Validator\AdExists;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @AdExists()
 */
class AdCreateRequestDto
{
    /**
     * @Assert\Length(max=30, min=3)
     */
    public ?string $title = null;
    /**
     * @Assert\Length(max=500, min=3)
     */
    public ?string $desc = null;
}
