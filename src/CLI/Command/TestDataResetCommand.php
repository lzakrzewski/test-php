<?php

declare(strict_types=1);

namespace BOF\CLI\Command;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestDataResetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('test:data:reset')
            ->setDescription('Reset MySQL data')
            ->addArgument('startDate', InputArgument::OPTIONAL, 'Start date')
            ->addArgument('endDate', InputArgument::OPTIONAL, 'End date');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Generating data');
        /** @var $db Connection */
        $db        = $this->getContainer()->get('database_connection');
        $startDate = $this->startDate($input);
        $endDate   = $this->endDate($input);

        $dataPerDay = 3;

        $db->query('TRUNCATE views');

        $profiles = $db->query('SELECT * FROM profiles')->fetchAll();

        $progress = $io->createProgressBar(count($profiles));
        foreach ($profiles as $profile) {
            $profileId   = $profile['profile_id'];
            $currentDate = $startDate;

            while ($currentDate <= $endDate) {
                for ($i = 0; $i <= $dataPerDay; ++$i) {
                    $views = rand(100, 9999);
                    $date  = date('Y-m-d', $currentDate);

                    $sql = sprintf(
                        "INSERT INTO views (`profile_id`, `date`, `views`) VALUES (%s, '%s', %s)",
                        $profileId,
                        $date,
                        $views
                    );
                    $db->query($sql);
                }

                $currentDate = mktime(0, 0, 0, (int) date('m', $currentDate), (int) date('d', $currentDate) + 1, (int) date('Y', $currentDate));
            }
            $progress->advance();
        }
    }

    private function startDate(InputInterface $input): int
    {
        $startDate = $input->getArgument('startDate');

        if ($startDate) {
            return strtotime($startDate);
        }

        return strtotime('2014-09-01');
    }

    private function endDate(InputInterface $input): int
    {
        $endDate = $input->getArgument('endDate');

        if ($endDate) {
            return strtotime($endDate);
        }

        return strtotime('2017-02-11');
    }
}
