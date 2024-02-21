<?php

namespace App\Tests\Domain\Unit\Model;

use Domain\Model\Employee;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * @param \DateTime $input
     * @param int $expected
     * @return void
     * @dataProvider provideData
     */
    public function testGetYearsOfWork(\DateTime $input, int $expected): void
    {
        $employee = new Employee();
        $employee->setStartedWorkAt($input);
        $this->assertEquals($expected, $employee->getYearsOfWork());
    }

    public function provideData(): array
    {
        return [
            '10 years worked' => [
                new \DateTime('now -10 year'),
                10
            ],
            '1 year worked' => [
                new \DateTime('now -1 year'),
                1
            ],
            'not worked a full year' => [
                new \DateTime('now'),
                0
            ],
        ];
    }
}