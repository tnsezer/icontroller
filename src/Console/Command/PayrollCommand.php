<?php

namespace App\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Util\CsvWriter;
use App\Util\DateUtil;

class PayrollCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('payroll:export')
            ->setDescription('Prepare payroll dates monthly and export it as CSV file');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output -> writeln([
            '',
            '******** Payroll Csv Export Console App ********',
            '================================================'
        ]);

        $header = ['Month', 'Salary Date', 'Bonus Date'];
        $data = $this->calculatePayrollMonthly();

        $fileName = $this->exportDataAsCsv($header, $data, __DIR__ . '/../../../data/report.csv');
        $output -> writeln([
            'Data exported to the path: ' . realpath($fileName),
            '================================================'
        ]);

        return 0;
    }

    /**
     * @param array $header
     * @param array $data
     * @param string $fileName
     * @return string
     */
    private function exportDataAsCsv(array $header, array $data, string $fileName): string
    {
        $csvFile = new CsvWriter($fileName, ';');
        return $csvFile->write($header, $data);
    }

    /**
     * @return array
     */
    private function calculatePayrollMonthly(): array
    {
        $data = [];
        for($i=1; $i<=12; $i++) {
            $dateUtil = new DateUtil();
            $dateUtil->setMonth($i);

            $nameOfMonth = $dateUtil->getNameOfMonth();

            $salaryDateObject = $dateUtil->getLastWeekDayOfMonth();
            if ($dateUtil->isWeekend()) {
                $salaryDateObject = $dateUtil->getLastFridayOfMonth();
            }
            $salaryDate = $salaryDateObject->format('Y-m-d');

            $bonusDateObject = $dateUtil->get15thOfMonth();
            if ($dateUtil->isWeekend()) {
                $bonusDateObject = $dateUtil->getWednesdayAfter15thOfMonth();
            }
            $bonusDate = $bonusDateObject->format('Y-m-d');

            $data[] = [$nameOfMonth, $salaryDate, $bonusDate];
        }

        return $data;
    }
}