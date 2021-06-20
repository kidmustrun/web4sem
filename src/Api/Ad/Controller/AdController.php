<?php

declare(strict_types=1);

namespace App\Api\Ad\Controller;

use App\Api\Ad\Dto\AdCreateRequestDto;
use App\Api\Ad\Dto\AdListResponseDto;
use App\Api\Ad\Dto\AdResponseDto;
use App\Api\Ad\Dto\AdUpdateRequestDto;
use App\Api\Ad\Dto\ValidationExampleRequestDto;
use App\Api\Ad\Factory\ResponseFactory;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Common\Factory\HTTPResponseFactory;
use App\Core\Ad\Document\Contact;
use App\Core\Ad\Document\Ad;
use App\Core\Ad\Enum\PermissionAd;
use App\Core\Ad\Repository\ContactRepository;
use App\Core\Ad\Repository\AdRepository;
use App\Core\Ad\Service\AdService;
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
     * @param Ad|null         $ad
     * @param ResponseFactory   $responseFactory
     *
     * @return AdResponseDto
     */
    public function show(Ad $ad = null, ResponseFactory $responseFactory)
    {
        if (!$ad) {
            throw $this->createNotFoundException('Ad not found');
        }

        return $responseFactory->createAdResponse($ad);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(PermissionAd::AD_INDEX)
     * @Rest\View()
     *
     * @param Request         $request
     * @param AdRepository  $adRepository
     * @param ResponseFactory $responseFactory
     *
     * @return AdListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        AdRepository $adRepository,
        ResponseFactory $responseFactory
    ): AdListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $ads = $adRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new AdListResponseDto(
            ... array_map(
                    function (Ad $ad) use ($responseFactory) {
                        return $responseFactory->createAdResponse($ad);
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
     * @param AdService                      $service
     * @param ResponseFactory                  $responseFactory
     * @param HTTPResponseFactory              $HTTPResponseFactory
     *
     * @return AdResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        AdCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        AdService $service,
        ResponseFactory $responseFactory,
        HTTPResponseFactory $HTTPResponseFactory
    ) {
        if ($validationErrors->count() > 0) {
            return $HTTPResponseFactory->createValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createAdResponse($service->createAd($requestDto));
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(PermissionAd::AD_UPDATE)
     * @ParamConverter("ad")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param Ad|null                        $ad
     * @param AdUpdateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param AdRepository                   $adRepository
     * @param ResponseFactory                  $responseFactory
     *
     * @return AdResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Ad $ad = null,
        AdUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        AdRepository $adRepository,
        ResponseFactory $responseFactory
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

        return $responseFactory->createAdResponse($ad);
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
}
