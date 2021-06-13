<?php

declare(strict_types=1);

namespace App\Api\Ad\Dto;

class AdListResponseDto
{
    public array $data;

    public function __construct(AdResponseDto ... $data)
    {
        $this->data = $data;
    }
}
