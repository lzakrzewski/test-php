<?php

declare(strict_types=1);

namespace tests\integration\BOF\CLI;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use tests\integration\BOF\DatabaseTestCase;

abstract class CLITestCase extends DatabaseTestCase
{
    /** @var CommandTester */
    private $tester;

    protected function executeCLI(Command $cli, array $parameters = [])
    {
        $this->tester = new CommandTester($cli);
        $this->tester->execute($parameters);
    }

    protected function assertExitCode(int $expectedStatus)
    {
        $this->assertEquals($expectedStatus, $this->tester->getStatusCode());
    }

    protected function assertDisplayContains(string $string)
    {
        $this->assertContains($string, $this->tester->getDisplay());
    }

    protected function tearDown()
    {
        $this->tester = null;
    }
}
