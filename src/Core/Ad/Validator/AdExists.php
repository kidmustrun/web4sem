<?php

declare(strict_types=1);

namespace App\Core\Ad\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AdExists extends Constraint
{
    public $message = 'Ad already exists, id: {{ adId }}';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
