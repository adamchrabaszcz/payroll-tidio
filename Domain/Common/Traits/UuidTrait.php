<?php

namespace Domain\Common\Traits;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

trait UuidTrait
{
    protected UuidV4 $id;

    public function generateUuid(): void
    {
        $this->id = Uuid::v4();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }
}