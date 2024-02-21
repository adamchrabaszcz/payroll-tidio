<?php

namespace App\Tests\Domain\Unit\Strategy;

use Domain\Exception\WrongBonusStrategySelectedException;
use Domain\Model\BonusType;
use Domain\Model\Department;
use Domain\Model\DepartmentBonus;
use Domain\Model\Employee;
use Domain\Strategy\FixedAmountBonusStrategy;
use Domain\Strategy\PercentageBonusStrategy;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\exactly;

class PercentageBonusStrategyTest extends TestCase
{
    public function testThrowsWrongBonusStrategySelectedException(): void
    {
        $this->expectException(WrongBonusStrategySelectedException::class);

        $employee = $this->createMock(Employee::class);
        $department = $this->createMock(Department::class);
        $departmentBonus = new DepartmentBonus(BonusType::FIXED, 10);

        $department
            ->expects(exactly(2))
            ->method('getDepartmentBonus')
            ->willReturn($departmentBonus);

        $strategy = new PercentageBonusStrategy();
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
        $departmentBonus = new DepartmentBonus(BonusType::PERCENTAGE, $input['bonusAmount']);

        $employee
            ->expects(exactly(1))
            ->method('getYearsOfWork')
            ->willReturn($input['yearsOfWork']);

        if ($input['yearsOfWork'] > 0) {
            $employee
                ->expects(exactly(1))
                ->method('getBaseSalary')
                ->willReturn($input['baseSalary']);
            $department
                ->expects(exactly(2))
                ->method('getDepartmentBonus')
                ->willReturn($departmentBonus);
        } else {
            $department
                ->expects(exactly(1))
                ->method('getDepartmentBonus')
                ->willReturn($departmentBonus);
        }

        $strategy = new PercentageBonusStrategy();
        $bonus = $strategy->calculateBonus($employee, $department);
        $this->assertEquals($expected, $bonus);
    }

    public function provideData(): array
    {
        return [
            'Worked 5 years, base salary 1100, 10% bonus = 110' => [
                [
                    'yearsOfWork' => 5,
                    'baseSalary' => 1100,
                    'bonusAmount' => 10
                ],
                110
            ],
            'Worked 10 years, base salary 1000, 10% bonus = 100' => [
                [
                    'yearsOfWork' => 10,
                    'baseSalary' => 1000,
                    'bonusAmount' => 10
                ],
                100
            ],
            'Worked 1 year, base salary 1000, 25% bonus = 250' => [
                [
                    'yearsOfWork' => 1,
                    'baseSalary' => 1000,
                    'bonusAmount' => 25
                ],
                250
            ],
            'not worked a full year, base salary 1000, 25% bonus = 0' => [
                [
                    'yearsOfWork' => 0,
                    'baseSalary' => 1000,
                    'bonusAmount' => 25
                ],
                0
            ],
            'Worked 5 years, base salary 1200, negative -25% bonus = 0' => [
                [
                    'yearsOfWork' => 5,
                    'baseSalary' => 1200,
                    'bonusAmount' => -25
                ],
                0
            ],
            'Worked 7 years, negative base salary -3200, 15% bonus = 0' => [
                [
                    'yearsOfWork' => 7,
                    'baseSalary' => -3200,
                    'bonusAmount' => 15
                ],
                0
            ],
        ];
    }
}