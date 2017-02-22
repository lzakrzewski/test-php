<?php

declare(strict_types=1);

namespace BOF\CLI\Command;

use BOF\Query\Month;
use BOF\Query\Profile;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReportYearlyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('report:profiles:yearly')
            ->setDescription('Page views report');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->table($this->renderHeaders(), $this->renderViews());
    }

    private function renderHeaders(): array
    {
        return array_merge([sprintf('Profile %d', 2015)], Month::allTitleNames());
    }

    private function renderViews(): array
    {
        $query = $this->getContainer()->get('app.query.report_yearly');

        return array_map(function (Profile $profile) {
            return array_merge([$profile->name], array_map(function (Month $month) {
                return $month->views;
            }, $profile->months));
        }, $query->get(2015));
    }
}
