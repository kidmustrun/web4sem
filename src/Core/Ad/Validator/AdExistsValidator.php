<?php

declare(strict_types=1);

namespace App\Core\Ad\Validator;

use App\Core\Ad\Repository\AdRepository;
use App\Core\Ad\Service\AdService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AdExistsValidator extends ConstraintValidator
{
    /**
     * @var AdService
     */
    private AdService $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof AdExists) {
            throw new UnexpectedTypeException($constraint, AdExists::class);
        }

        $ad = $this->adService->findOneBy(['id' => $value->id]);

        if ($ad) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ adId }}', $ad->getId())
                ->addViolation();
        }
    }
}
