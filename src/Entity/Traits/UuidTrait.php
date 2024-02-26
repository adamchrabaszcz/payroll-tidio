<?php

namespace App\Entity\Traits;

use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

trait UuidTrait
{
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    public function getId(): Uuid
    {
        return $this->id;
    }
}