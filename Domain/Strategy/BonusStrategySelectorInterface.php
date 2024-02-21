<?php

namespace Domain\Strategy;

use Domain\Model\BonusType;

interface BonusStrategySelectorInterface
{
    public function selectBonusStrategy(BonusType $bonusType): BonusStrategyInterface;
}