<?php
declare(strict_types=1);

namespace App\Command;

use App\Application\CommissionCalculator\CommissionCalculatorInterface;
use App\Application\CommissionCalculator\Transaction;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:calculate-commission')]
class CommissionCalculateCommand extends Command
{
    public function __construct(
        private CommissionCalculatorInterface $commissionCalculator
    )
    {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            foreach (json_decode(file_get_contents(__DIR__.'/transactions.json'), true) as $data) {
                echo $this->commissionCalculator->calculate(Transaction::create($data));
                print "\n";
            }
        } catch (\Exception $exception) {
            $output->write($exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}