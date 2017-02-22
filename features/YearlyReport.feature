Feature: View yearly report

  Scenario: View yearly report with monthly breakdown
    Given that there is historical data available:
        | profile_id | profile_name | date       | views |
        | 1          | John Doe     | 2015-01-01 | 1111  |
        | 2          | Joan Doe     | 2015-12-01 | 2222  |
     When I execute the Yearly Views report for "2015"
     Then I expect to see a monthly breakdown of the total views per profiles:
        | Jan | Feb |  Mar | Apr | May | Jun | Jul | Aug | Sep | Oct | Nov | Dec |

  Scenario: View yearly report with profiles names listed in alphabetical order
    Given that there is historical data available:
        | profile_id | profile_name | date       | views |
        | 1          | Tom Ford     | 2015-01-01 | 1111  |
        | 2          | Anna Wintour | 2015-12-01 | 2222  |
     When I execute the Yearly Views report for "2015"
     Then I expect to have the profiles names listed in alphabetical order:
        | Anna Wintour |
        | Tom Ford     |

  Scenario: View yearly report when data is not available
    Given that there is no historical data available
     When I execute the Yearly Views report for "2015"
     Then I expect to see "n/a" when data is not available
