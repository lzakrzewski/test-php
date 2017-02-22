<?php

declare(strict_types=1);

namespace tests\integration\BOF\CLI\Command;

use BOF\CLI\Command\TestDataResetCommand;
use tests\integration\BOF\CLI\CLITestCase;

class TestDataResetCommandTest extends CLITestCase
{
    /** @var TestDataResetCommand */
    private $command;

    /** @test **/
    public function it_can_return_0_status_code_when_test_data_command_was_executed()
    {
        $this->addProfile(1, 'John Doe');
        $this->addViews(1, '2015-01-01', 12);

        $this->executeCLI($this->command, ['startDate' => '2015-01-01 00:00:00', 'endDate' => '2015-01-01 00:00:01']);

        $this->assertExitCode(0);
        $this->assertDisplayContains('Generating data');
        $this->assertThatViewsTableIsNotEmpty();
    }

    protected function setUp()
    {
        parent::setUp();

        $this->command = $this->container()->get('app.command.test_reset_data');
    }

    protected function tearDown()
    {
        $this->command = null;

        parent::tearDown();
    }

    private function assertThatViewsTableIsNotEmpty()
    {
        $this->assertNotEmpty($this->connection()->fetchAll('SELECT * FROM views'));
    }
}
