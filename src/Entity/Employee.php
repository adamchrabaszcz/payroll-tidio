<?php

namespace App\Entity;

use App\Entity\Traits\UuidTrait;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    use UuidTrait;

    #[ORM\Column(length: 255)]
    private string $firstName;

    #[ORM\Column(length: 255)]
    private string $lastName;

    #[ORM\Column]
    private int $baseSalary;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $startedWorkAt;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    #[ORM\JoinColumn(nullable: false)]
    private Department $department;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }

    public function setBaseSalary(int $baseSalary): static
    {
        $this->baseSalary = $baseSalary;

        return $this;
    }

    public function getStartedWorkAt(): \DateTimeInterface
    {
        return $this->startedWorkAt;
    }

    public function setStartedWorkAt(\DateTimeInterface $startedWorkAt): static
    {
        $this->startedWorkAt = $startedWorkAt;

        return $this;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function setDepartment(Department $department): static
    {
        $this->department = $department;

        return $this;
    }
}
