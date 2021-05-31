<?php

declare(strict_types=1);

namespace App\Core\Ad\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Ad\Repository\AdRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass=AdRepository::class, collection="ads")
 */
class Ad extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $title = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $desc = null;


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDesc(): ?string
    {
        return $this->desc;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setDesc(?string $desc): void
    {
        $this->desc = $desc;
    }
}
