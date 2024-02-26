<?php

namespace App\Tests\Domain\Unit\Provider;

use Domain\Exception\NoFilterValueException;
use Domain\Exception\NoSortDirectionException;
use Domain\Exception\NotAllowedToFilterException;
use Domain\Factory\ReportFactoryInterface;
use Domain\Model\Employee;
use Domain\Model\Report;
use Domain\Provider\ReportProvider;
use Domain\Repository\EmployeeRepositoryInterface;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\atLeast;
use function PHPUnit\Framework\exactly;

class ReportProviderTest extends TestCase
{
    public function testThrowsNotAllowedToFilterException(): void
    {
        $this->expectException(NotAllowedToFilterException::class);

        $reportFactory = $this->getMockForAbstractClass(ReportFactoryInterface::class);
        $employeeRepository = $this->getMockForAbstractClass(EmployeeRepositoryInterface::class);

        $reportProvider = new ReportProvider($reportFactory, $employeeRepository);
        $reportProvider->provideReportForMonth(date('F'), ['field' => 'bonus']);
    }

    public function testThrowsNoFilterValueException(): void
    {
        $this->expectException(NoFilterValueException::class);

        $reportFactory = $this->getMockForAbstractClass(ReportFactoryInterface::class);
        $employeeRepository = $this->getMockForAbstractClass(EmployeeRepositoryInterface::class);

        $reportProvider = new ReportProvider($reportFactory, $employeeRepository);
        $reportProvider->provideReportForMonth(date('F'), ['field' => 'firstName']);
    }

    public function testThrowsNoSortDirectionException(): void
    {
        $this->expectException(NoSortDirectionException::class);

        $reportFactory = $this->getMockForAbstractClass(ReportFactoryInterface::class);
        $employeeRepository = $this->getMockForAbstractClass(EmployeeRepositoryInterface::class);

        $reportProvider = new ReportProvider($reportFactory, $employeeRepository);
        $reportProvider->provideReportForMonth(
            date('F'),
            ['field' => 'firstName', 'value' => 'test'],
            ['field' => 'firstName']
        );
    }

    public function testPreSort(): void
    {
        $reportFactory = $this->getMockForAbstractClass(ReportFactoryInterface::class);
        $employeeRepository = $this->getMockForAbstractClass(EmployeeRepositoryInterface::class);
        $employee = $this->createMock(Employee::class);
        $employees = [$employee, $employee];
        $report = $this->createMock(Report::class);

        $employeeRepository
            ->expects(self::once())
            ->method('getAllBy')
            ->willReturn($employees);

        $reportFactory
            ->expects(self::once())
            ->method('createReportForMonthFromEmployees')
            ->willReturn($report);

        $report
            ->expects(exactly(0))
            ->method('getReportRows');
        $report
            ->expects(exactly(0))
            ->method('updateReportRows');

        $reportProvider = new ReportProvider($reportFactory, $employeeRepository);
        $returnedReport = $reportProvider->provideReportForMonth(
            date('F'),
            ['field' => 'firstName', 'value' => 'test'],
            ['field' => 'firstName', 'direction' => 'test']
        );

        $this->assertInstanceOf(Report::class, $returnedReport);
        $this->assertEquals($report, $returnedReport);
    }

    public function testPostSort(): void
    {
        $reportFactory = $this->getMockForAbstractClass(ReportFactoryInterface::class);
        $employeeRepository = $this->getMockForAbstractClass(EmployeeRepositoryInterface::class);
        $employee = $this->createMock(Employee::class);
        $employees = [$employee, $employee];
        $report = $this->createMock(Report::class);

        $employeeRepository
            ->expects(self::once())
            ->method('getAllBy')
            ->willReturn($employees);

        $reportFactory
            ->expects(self::once())
            ->method('createReportForMonthFromEmployees')
            ->willReturn($report);

        $report
            ->expects(atLeast(1))
            ->method('getReportRows');
        $report
            ->expects(exactly(1))
            ->method('updateReportRows');

        $reportProvider = new ReportProvider($reportFactory, $employeeRepository);
        $returnedReport = $reportProvider->provideReportForMonth(
            date('F'),
            [],
            ['field' => 'bonus', 'direction' => 'ASC']
        );

        $this->assertInstanceOf(Report::class, $returnedReport);
    }
}