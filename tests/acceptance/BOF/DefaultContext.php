<?php

declare(strict_types=1);

namespace tests\acceptance\BOF;

use BOF\Application;
use BOF\CLI\Command\ReportYearlyCommand;
use BOF\Query\YearlyReportQuery;
use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use tests\dictionary\BOF\Persistence;

abstract class DefaultContext
{
    use Persistence;

    /** @var ContainerInterface */
    private $container;

    /** @var Connection */
    private $connection;

    /** @var YearlyReportQuery */
    private $command;

    /**
     * @beforeScenario
     */
    public function beforeScenario()
    {
        $app = new Application();

        $this->container  = $app->getContainer();
        $this->connection = $app->getContainer()->get('database_connection');
        $this->command    = $app->getContainer()->get('app.command.report_yearly');

        $this->setupDatabase();
    }

    protected function container(): ContainerInterface
    {
        return $this->container;
    }

    protected function connection(): Connection
    {
        return $this->connection;
    }

    protected function command(): ReportYearlyCommand
    {
        return $this->command;
    }
}
