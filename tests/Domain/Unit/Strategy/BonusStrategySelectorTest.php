<?php

namespace App\Tests\Domain\Unit\Strategy;

use Domain\Model\BonusType;
use Domain\Strategy\BonusStrategyInterface;
use Domain\Strategy\BonusStrategySelector;
use Domain\Strategy\FixedAmountBonusStrategy;
use Domain\Strategy\PercentageBonusStrategy;
use PHPUnit\Framework\TestCase;

class BonusStrategySelectorTest extends TestCase
{
    /**
     * @param BonusType $input
     * @param string $expected
     * @return void
     * @dataProvider provideData
     */
    public function testSelectBonusStrategy(BonusType $input, string $expected): void
    {
        $strategy = new BonusStrategySelector();
        $this->assertInstanceOf($expected, $strategy->selectBonusStrategy($input));
    }

    public function provideData(): array
    {
        return [
            'fixed' => [
                BonusType::FIXED,
                FixedAmountBonusStrategy::class
            ],
            'percentage' => [
                BonusType::PERCENTAGE,
                PercentageBonusStrategy::class
            ],
        ];
    }
}