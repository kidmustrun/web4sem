<?php

declare(strict_types=1);

namespace App\Core\Ad\Repository;

use App\Core\Common\Repository\AbstractRepository;
use App\Core\Ad\Document\Ad;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Ad save(Ad $ad)
 * @method Ad|null find(string $id)
 * @method Ad|null findOneBy(array $criteria)
 * @method Ad getOne(string $id)
 */
class AdRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Ad::class;
    }

    /**
     * @throws LockException
     * @throws MappingException
     */
    public function getAdById(string $id): ?Ad
    {
        return $this->find($id);
    }
}
