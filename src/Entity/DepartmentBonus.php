<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Domain\Model\BonusType;

#[ORM\Embeddable()]
class DepartmentBonus
{
    #[ORM\Column(type: 'string', enumType: BonusType::class)]
    private BonusType $bonusType;

    #[ORM\Column()]
    private int $amount;

    public function __construct(
        BonusType $bonusType,
        int $amount
    ) {
        $this->bonusType = $bonusType;
        $this->amount = $amount;
    }

    public function equals(DepartmentBonus $departmentBonus): bool
    {
        return $this->bonusType === $departmentBonus->bonusType && $this->amount === $departmentBonus->amount;
    }

    public function getBonusType(): BonusType
    {
        return $this->bonusType;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}