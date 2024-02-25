<?php

namespace Domain\Model\Traits;

trait FirstNameTrait
{
    private string $firstName;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
}