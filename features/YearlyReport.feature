Feature: View yearly report

  @incomplete
  Scenario: View yearly report with monthly breakdown
    Given that there is historical data available
     When I execute the Yearly Views report
     Then I expect to see a monthly breakdown of the total views per profiles

  @incomplete
  Scenario: View yearly report with profiles names listed in alphabetical order
    Given that there is historical data available
     When I view the Yearly Views report
     Then I expect to have the profiles names listed in alphabetical order

  @incomplete
  Scenario: View yearly report when data is not available
    Given that there is historical data available
     When I view the Yearly Views report
     Then I expect to see "n/a" when data is not available