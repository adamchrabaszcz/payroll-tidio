<?php

namespace Domain\Model\Traits;

trait LastNameTrait
{
    private string $lastName;

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}