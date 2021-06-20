<?php

declare(strict_types=1);

namespace App\Api\Ad\Factory;

use App\Api\Ad\Dto\ContactResponseDto;
use App\Api\Ad\Dto\AdResponseDto;
use App\Core\Ad\Document\Ad;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * @param Ad         $ad
     *
     * @return AdResponseDto
     */
    public function createAdResponse(Ad $ad): AdResponseDto
    {
        $dto = new AdResponseDto();

        $dto->id           = $ad->getId();
        $dto->title        = $ad->getTitle();
        $dto->desc         = $ad->getDesc();

        return $dto;
    }
}
