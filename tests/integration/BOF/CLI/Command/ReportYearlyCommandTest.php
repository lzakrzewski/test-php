<?php

declare(strict_types=1);

namespace tests\integration\BOF\CLI\Command;

use BOF\CLI\Command\ReportYearlyCommand;
use tests\integration\BOF\CLI\CLITestCase;

class ReportYearlyCommandTest extends CLITestCase
{
    /** @var ReportYearlyCommand */
    private $command;

    /** @test **/
    public function it_can_return_0_status_code_when_report_command_was_executed()
    {
        $this->executeCLI($this->command);

        $this->assertExitCode(0);
        $this->assertDisplayContains('Profile');
    }

    protected function setUp()
    {
        parent::setUp();

        $this->command = $this->container()->get('app.command.report_yearly');
    }

    protected function tearDown()
    {
        $this->command = null;

        parent::tearDown();
    }
}
