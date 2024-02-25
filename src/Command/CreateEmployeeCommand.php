<?php

namespace App\Command;

use App\Manager\EmployeeManagerInterface;
use App\Repository\DepartmentRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:employee:create',
    description: 'Creates an Employee.',
    hidden: false
)]
class CreateEmployeeCommand extends Command
{
    private EmployeeManagerInterface $employeeManager;
    private DepartmentRepository $departmentRepository;

    public function __construct(
        EmployeeManagerInterface $employeeManager,
        DepartmentRepository $departmentRepository,
    ) {
        parent::__construct();
        $this->employeeManager = $employeeManager;
        $this->departmentRepository = $departmentRepository;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates an Employee.')
            ->setHelp('This command allows you to create an Employee.')
            ->addArgument('firstName', InputArgument::OPTIONAL)
            ->addArgument('lastName', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Employee creator.');

        $firstName = $input->getArgument('firstName');

        if (! $firstName) {
            $question = new Question('First name');
            $firstName = $io->askQuestion($question);
        }

        $lastName = $input->getArgument('lastName');

        if (! $lastName) {
            $question = new Question('Last name');
            $lastName = $io->askQuestion($question);
        }

        $question = new Question("\u{1F4B8} Base salary amount");
        $baseSalary = $io->askQuestion($question);

        $question = new Question('Started work at (YYYY-MM-DD)');
        $dateString = $io->askQuestion($question);
        $startedWorkAt = \DateTime::createFromFormat('Y-m-d', $dateString);

        $departments = $this->departmentRepository->findAll();
        $departmentChoices = [];
        foreach ($departments as $department) {
            $departmentChoices[] = $department->getName();
        }

        $io->section("\u{1F3E2}  Select Department.");
        $selectedDepartmentName = $io->choice('Please pick a Department', $departmentChoices);
        $selectedDepartment = $this->departmentRepository->findOneBy(['name' => $selectedDepartmentName]);

        $employee = $this->employeeManager->createEmployeeFromBasicDetailsAndDepartment(
            $firstName,
            $lastName,
            $baseSalary,
            $startedWorkAt,
            $selectedDepartment
        );

        if ($employee->getId()) {
            $io->success('Employee created.');
            return Command::SUCCESS;
        }

        $io->error('Employee not created.');
        return Command::FAILURE;
    }
}