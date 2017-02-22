<?php

declare(strict_types=1);

namespace BOF\CLI\Command;

use BOF\Query\Month;
use BOF\Query\Profile;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReportYearlyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('report:profiles:yearly')
            ->setDescription('Page views report')
            ->addArgument('year', InputArgument::OPTIONAL, 'Year ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $year = $this->year($input);

            $this->renderReport($year, $input, $output);
        } catch (\InvalidArgumentException $exception) {
            $output->writeln(sprintf('<error>%s</error>', $exception));

            return 1;
        }
    }

    private function year(InputInterface $input): int
    {
        $year = $input->getArgument('year');

        if (null === $year) {
            return (int) (new \DateTime())->format('Y');
        }

        if (false === is_numeric($year) || false === is_integer($year)) {
            throw new \InvalidArgumentException(sprintf('Year should be numeric integer. "%s" given', $year));
        }

        return (int) $year;
    }

    private function renderReport(int $year, InputInterface $input, OutputInterface $output)
    {
        $report = $this->getContainer()->get('app.query.report_yearly')->get($year);

        if (empty($report)) {
            $output->writeln('n/a');

            return;
        }

        $io = new SymfonyStyle($input, $output);
        $io->table(
            array_merge([sprintf('Profile %d', $year)], Month::allTitleNames()),
            array_map([$this, 'mapProfilesToRawData'], $report)
        );
    }

    private function mapProfilesToRawData(Profile $profile): array
    {
        return array_merge([$profile->name], array_map(function (Month $month) {
            return $month->views;
        }, $profile->months));
    }
}
