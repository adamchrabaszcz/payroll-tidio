<?php

namespace App\Command;

use App\Manager\DepartmentManagerInterface;
use Domain\Model\BonusType;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:department:create',
    description: 'Creates a Department.',
    hidden: false
)]
class CreateDepartmentCommand extends Command
{
    private DepartmentManagerInterface $departmentManager;

    public function __construct(
        DepartmentManagerInterface $departmentManager
    ) {
        parent::__construct();
        $this->departmentManager = $departmentManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a Department.')
            ->setHelp('This command allows you to create a Department.')
            ->addArgument('name', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Department creator.');

        $name = $input->getArgument('name');

        if (! $name) {
            $question = new Question('Name');
            $name = $io->askQuestion($question);
        }

        $io->section("\u{1F3E6}  Select Bonus type.");
        $bonusType = match ($io->choice('Please pick a Bonus type', [BonusType::FIXED->value, BonusType::PERCENTAGE->value])) {
            BonusType::FIXED->value => BonusType::FIXED,
            BonusType::PERCENTAGE->value => BonusType::PERCENTAGE
        };

        $question = new Question(sprintf('Amount (%s)', $bonusType == BonusType::PERCENTAGE ? '%' : '$'));
        $amount = $io->askQuestion($question);

        $department = $this->departmentManager->createDepartmentFromNameAndBonus($name, $bonusType, $amount);

        if ($department->getId()) {
            $io->success('Department created.');
            return Command::SUCCESS;
        }

        $io->error('Department not created.');
        return Command::FAILURE;
    }
}