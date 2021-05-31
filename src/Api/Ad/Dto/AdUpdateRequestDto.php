<?php

declare(strict_types=1);

namespace App\Api\Ad\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AdUpdateRequestDto
{
    /**
     * @Assert\Length(max=100, min=3)
     */
    public ?string $title = null;

    public ?string $desc = null;
}
