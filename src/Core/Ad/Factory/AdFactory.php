<?php

declare(strict_types=1);

namespace App\Core\Ad\Factory;

use App\Core\Ad\Document\Ad;

class AdFactory
{
    public function create(
        string $title,
        string $desc
    ): Ad {
        $ad = new Ad(
            $title,
            $desc
        );

        return $ad;
    }
    public function update(
        $ad,
        string $title,
        string $desc
    ){
        $ad->setTitle($title);
        $ad->setDesc($desc);
    }
}