<?php

namespace Domain\Model;

final class DepartmentBonus
{
    public function __construct(
        private BonusType $bonusType,
        private int $amount
    ) {}

    public function getBonusType(): BonusType
    {
        return $this->bonusType;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}