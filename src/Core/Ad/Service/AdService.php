<?php

declare(strict_types=1);

namespace App\Core\Ad\Service;

use App\Api\Ad\Dto\AdCreateRequestDto;
use App\Api\Ad\Dto\AdUpdateRequestDto;
use App\Core\Ad\Document\Ad;
use App\Core\Ad\Factory\AdFactory;
use App\Core\Ad\Repository\AdRepository;
use Psr\Log\LoggerInterface;

class AdService
{
    /**
     * @var AdRepository
     */
    private AdRepository $adRepository;

    /**
     * @var AdFactory
     */
    private AdFactory $adFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(AdRepository $adRepository, AdFactory $adFactory, LoggerInterface $logger)
    {
        $this->adRepository = $adRepository;
        $this->adFactory    = $adFactory;
        $this->logger       = $logger;
    }

    public function findOneBy(array $criteria): ?Ad
    {
        return $this->adRepository->findOneBy($criteria);
    }

    public function updateAd(string $id, AdUpdateRequestDto $requestDto)
    {
        $ad = $this->find($id);

        $ad = $adFactory->update( $ad,
            $requestDto->title,
            $requestDto->desc
        );

        $ad = $adRepository->save($ad);

        $this->logger->info('Ad updated successfully', [
            'id' => $ad->getId(),
            'title' => $ad->getTitle(),
            'desc' => $ad->getDesc()
        ]);

        return $ad;
    }

    public function createAd(AdCreateRequestDto $requestDto): Ad
    {
        $ad = $this->adFactory->create(
            $requestDto->title,
            $requestDto->desc
        );

        $ad = $this->adRepository->save($ad);

        $this->logger->info('Ad created successfully', [
            'ad_id' => $ad->getId(),
            'title' => $ad->getTitle(),
        ]);

        return $ad;
    }
}
