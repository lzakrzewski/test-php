<?php

declare(strict_types=1);

namespace tests\acceptance\BOF;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Tester\CommandTester;

class YearlyReportContext extends DefaultContext implements Context
{
    /** @var CommandTester */
    private $tester;

    /**
     * @Given that there is historical data available:
     */
    public function thatThereIsHistoricalDataAvailable(TableNode $table)
    {
        $data = $table->getRows();

        array_shift($data);

        foreach ($data as $row) {
            $this->persistProfile((int) $row[0], $row[1]);
            $this->persistView((int) $row[0], $row[2], (int) $row[3]);
        }
    }

    /**
     * @When I execute the Yearly Views report for :year
     */
    public function iExecuteTheYearlyViewsReport(int $year)
    {
        $this->tester = new CommandTester($this->command());
        $this->tester->execute(['year' => $year]);
    }

    /**
     * @Then I expect to see a monthly breakdown of the total views per profiles:
     */
    public function iExpectToSeeAMonthlyBreakdownOfTheTotalViewsPerProfiles(TableNode $table)
    {
        $breakdown = $table->getRows();
        $display   = $this->tester->getDisplay();

        foreach ($breakdown[0] as $month) {
            Assert::stringContains($month)->evaluate($display);
        }
    }

    /**
     * @Then I expect to have the profiles names listed in alphabetical order:
     */
    public function iExpectToHaveTheProfilesNamesListedInAlphabeticalOrder(TableNode $table)
    {
        $list    = $table->getRows();
        $display = $this->tester->getDisplay();

        $positions = [];

        foreach ($list as $row) {
            $positions[] = strpos($display, $row[0]);
        }

        $expected = $positions;
        sort($expected);

        Assert::equalTo($expected)->evaluate($positions);
    }

    /**
     * @Given that there is no historical data available
     */
    public function thatThereIsNoHistoricalDataAvailable()
    {
    }

    /**
     * @Then I expect to see :arg1 when data is not available
     */
    public function iExpectToSeeWhenDataIsNotAvailable($expectedOutput)
    {
        $display = $this->tester->getDisplay();

        Assert::stringContains($expectedOutput)->evaluate($display);
    }

    /**
     * @Transform :year
     */
    public function year($year): int
    {
        return (int) $year;
    }
}
