<?php

namespace Domain\Strategy;

use Domain\Model\BonusType;

final class BonusStrategySelector implements BonusStrategySelectorInterface
{
    public function selectBonusStrategy(BonusType $bonusType): BonusStrategyInterface
    {
        return match ($bonusType) {
            BonusType::FIXED => new FixedAmountBonusStrategy(),
            BonusType::PERCENTAGE => new PercentageBonusStrategy()
        };
    }
}