<?php

namespace App\Tests\Domain\Unit\Strategy;

use Domain\Exception\WrongBonusStrategySelectedException;
use Domain\Model\BonusType;
use Domain\Model\Department;
use Domain\Model\DepartmentBonus;
use Domain\Model\Employee;
use Domain\Strategy\FixedAmountBonusStrategy;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\exactly;

class FixedAmountBonusStrategyTest extends TestCase
{
    public function testThrowsWrongBonusStrategySelectedException(): void
    {
        $this->expectException(WrongBonusStrategySelectedException::class);

        $employee = $this->createMock(Employee::class);
        $department = $this->createMock(Department::class);
        $departmentBonus = new DepartmentBonus(BonusType::PERCENTAGE, 10);

        $department
            ->expects(exactly(2))
            ->method('getDepartmentBonus')
            ->willReturn($departmentBonus);

        $strategy = new FixedAmountBonusStrategy();
        $strategy->calculateBonus($employee, $department);
    }

    /**
     * @param array $input
     * @param int $expected
     * @return void
     * @dataProvider provideData
     */
    public function testCalculateBonus(array $input, int $expected): void
    {
        $employee = $this->createMock(Employee::class);
        $department = $this->createMock(Department::class);
        $departmentBonus = new DepartmentBonus(BonusType::FIXED, $input['bonusAmount']);

        $employee
            ->expects(exactly(1))
            ->method('getYearsOfWork')
            ->willReturn($input['yearsOfWork']);
        $department
            ->expects(exactly(2))
            ->method('getDepartmentBonus')
            ->willReturn($departmentBonus);

        $strategy = new FixedAmountBonusStrategy();
        $bonus = $strategy->calculateBonus($employee, $department);
        $this->assertEquals($expected, $bonus);
    }

    public function provideData(): array
    {
        return [
            '15 years worked, fixed bonus amount of 100/year = 1000 (cap on 10 years)' => [
                [
                    'yearsOfWork' => 15,
                    'bonusAmount' => 100
                ],
                1000
            ],
            '10 years worked, fixed bonus amount of 100/year = 1000' => [
                [
                    'yearsOfWork' => 10,
                    'bonusAmount' => 100
                ],
                1000
            ],
            '1 year worked, fixed bonus amount of 50/year = 50' => [
                [
                    'yearsOfWork' => 1,
                    'bonusAmount' => 50
                ],
                50
            ],
            'not worked a full year, fixed bonus amount of 100/year = 0' => [
                [
                    'yearsOfWork' => 0,
                    'bonusAmount' => 100
                ],
                0
            ],
            'date in the future, fixed bonus amount of 100/year = 0' => [
                [
                    'yearsOfWork' => -5,
                    'bonusAmount' => 100
                ],
                0
            ],
            '10 years worked, negative bonus amount of -100/year = 0' => [
                [
                    'yearsOfWork' => 10,
                    'bonusAmount' => -100
                ],
                0
            ],
        ];
    }
}