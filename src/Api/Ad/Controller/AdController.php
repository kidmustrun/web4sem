<?php

declare(strict_types=1);

namespace App\Api\Ad\Controller;

use App\Api\Ad\Dto\AdCreateRequestDto;
use App\Api\Ad\Dto\AdListResponseDto;
use App\Api\Ad\Dto\AdResponseDto;
use App\Api\Ad\Dto\AdUpdateRequestDto;
use App\Api\Ad\Dto\ValidationExampleRequestDto;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Ad\Document\Ad;
use App\Core\Ad\Enum\PermissionAd;
use App\Core\Ad\Repository\AdRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/ads")
 */
class AdController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(PermissionAd::AD_SHOW)
     *
     * @ParamConverter("ad")
     *
     * @Rest\View()
     *
     * @param Ad|null $ad
     *
     * @return AdResponseDto
     */
    public function show(Ad $ad = null)
    {
        if (!$ad) {
            throw $this->createNotFoundException('Ad not found');
        }

        return $this->createAdResponse($ad);
    }

     /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(PermissionAd::AD_INDEX)
     * @Rest\View()
     *
     * @return AdListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        AdRepository $adRepository
    ): AdListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $ads = $adRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new AdListResponseDto(
            ... array_map(
                    function (Ad $ad) {
                        return $this->createAdResponse($ad);
                    },
                    $ads
                )
        );
    }

    /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(PermissionAd::AD_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param AdCreateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param AdRepository                   $adRepository
     *
     * @return AdResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        AdCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        AdRepository $adRepository
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        if ($ad = $adRepository->findOneBy(['phone' => $requestDto->phone])) {
            return new Response('Ad already exists', Response::HTTP_BAD_REQUEST);
        }

        $ad = new Ad(
            $requestDto->title,
            $requestDto->desc
        );
        $ad->setTitle($requestDto->title);
        $ad->setDesc($requestDto->desc);

        $adRepository->save($ad);

        return $this->createAdResponse($ad);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(PermissionAd::AD_UPDATE)
     * @ParamConverter("ad")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param AdUpdateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param AdRepository                   $adRepository
     *
     * @return AdResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Ad $ad = null,
        AdUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        AdRepository $adRepository
    ) {
        if (!$ad) {
            throw $this->createNotFoundException('Ad not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        $ad->setTitle($requestDto->title);
        $ad->setDesc($requestDto->desc);

        $adRepository->save($ad);

        return $this->createAdResponse($ad);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(PermissionAd::AD_DELETE)
     * @ParamConverter("ad")
     *
     * @Rest\View()
     *
     * @param Ad|null      $ad
     * @param AdRepository $adRepository
     *
     * @return AdResponseDto|ValidationFailedResponse
     */
    public function delete(
        AdRepository $adRepository,
        Ad $ad = null
    ) {
        if (!$ad) {
            throw $this->createNotFoundException('Ad not found');
        }

        $adRepository->remove($ad);
    }

    /**
     * @Route(path="/validation", methods={"POST"})
     * @IsGranted(PermissionAd::AD_VALIDATION)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @return ValidationExampleRequestDto|ValidationFailedResponse
     */
    public function validation(
        ValidationExampleRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $requestDto;
    }

    /**
     * @param Ad         $ad
     *
     * @return AdResponseDto
     */
    private function createAdResponse(Ad $ad): AdResponseDto
    {
        $dto = new AdResponseDto();

        $dto->id                = $ad->getId();
        $dto->title        = $ad->getTitle();
        $dto->desc          = $ad->getDesc();

        return $dto;
    }

}