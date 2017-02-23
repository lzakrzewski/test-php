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
    public function it_can_return_0_when_input_contains_an_year()
    {
        $this->persistProfile(1, 'John Doe');
        $this->persistView(1, '2015-01-01', 1);

        $this->executeCLI($this->command, ['year' => 2015]);

        $this->assertExitCode(0);
        $this->assertDisplayContains('Profile');
    }

    /** @test **/
    public function it_can_return_0_when_input_does_not_contains_an_year()
    {
        $this->persistProfile(1, 'John Doe');
        $this->persistView(1, (new \DateTime())->format('Y-m-d'), 1);

        $this->executeCLI($this->command);

        $this->assertExitCode(0);
        $this->assertDisplayContains('Profile');
    }

    /** @test **/
    public function it_can_return_0_status_code_when_no_data_in_database()
    {
        $this->executeCLI($this->command, ['year' => 2015]);

        $this->assertExitCode(0);
        $this->assertDisplayContains('n/a');
    }

    /** @test **/
    public function it_can_return_0_when_data_is_incomplete()
    {
        $this->persistProfile(1, 'John Doe');

        $this->executeCLI($this->command, ['year' => 2015]);

        $this->assertExitCode(0);
        $this->assertDisplayContains('n/a');
    }

    /** @test @dataProvider invalidYears **/
    public function it_returns_1_when_year_is_invalid()
    {
        $this->executeCLI($this->command, ['year' => 'invalid']);

        $this->assertExitCode(1);
    }

    public function invalidYears(): array
    {
        return [
            ['invalid'],
            ['abcd'],
        ];
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
