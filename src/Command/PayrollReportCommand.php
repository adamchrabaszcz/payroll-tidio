<?php

namespace App\Command;

use Domain\Exception\NotAllowedToFilterException;
use Domain\Provider\ReportProviderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:payroll-report',
    description: 'Creates a payroll report.',
    hidden: false
)]
class PayrollReportCommand extends Command
{
    private ReportProviderInterface $reportProvider;

    public function __construct(
        ReportProviderInterface $reportProvider
    ) {
        parent::__construct();
        $this->reportProvider = $reportProvider;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a payroll report.')
            ->setHelp('This command allows you to create a payroll report.')
        ;
    }

    /**
     * @throws NotAllowedToFilterException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title(sprintf('Payroll Report for %s.', date('F')));

        // For future use - might be worth asking for the month of the Report.
        //Some additional logic needed for edge cases.
        /*$month = $io->choice(
            'Please select month',
            array_combine(
                range(1,12),
                array_map(
                    fn($x) => \DateTime::createFromFormat('!m', $x)->format('F'),
                    range(1,12)
                )
            ),
            date('n')
        );*/

        $this->printReportTable($output, [], []);
        $io->newLine();

        $filterBy = [];
        $filterByField = $io->choice(
            'Filter by',
            array_merge(['none'], ReportProviderInterface::FIELDS_ALLOWED_TO_FILTER),
            0
        );

        if ('none' !== $filterByField) {
            $question = new Question(sprintf('Enter %s to filter', $filterByField));
            $filterByValue = $io->askQuestion($question);
            $filterBy = [
                'field' => $filterByField,
                'value' => $filterByValue
            ];
        }

        $sortBy = [];
        $sortByField = $io->choice(
            'Sort by',
            array_merge(
                ['none'],
                ReportProviderInterface::FIELDS_SORTABLE
            ),
            0
        );

        if ('none' !== $sortByField) {
            $sortByDirection = $io->choice(
                'ASC / DESC',
                ['ASC', 'DESC'],
                0
            );
            $sortBy = [
                'field' => $sortByField,
                'direction' => $sortByDirection
            ];
        }

        $this->printReportTable($output, $filterBy, $sortBy);

        return Command::SUCCESS;
    }

    /**
     * @param OutputInterface $output
     * @param array $filterBy
     * @param array $sortBy
     * @return void
     * @throws NotAllowedToFilterException
     */
    private function printReportTable(OutputInterface $output, array $filterBy, array $sortBy): void
    {
        $table = new Table($output);
        $table
            ->setHeaders([
                'Name',
                'Surname',
                'Department',
                'Remuneration base (amount)',
                'Addition to the base (amount)',
                'Bonus type (% or fixed type)',
                'Salary with bonus (amount)'
            ]);

        $report = $this->reportProvider->provideReportForMonth(date('n'), $filterBy, $sortBy);

        foreach ($report->getReportRows() as $reportRow) {
            $table->addRow($reportRow->getRow());
        }

        $table->render();
    }
}