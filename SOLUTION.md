SOLUTION
========

Estimation
----------
Estimated: 5h hours

Spent: 5-10h hours (I worked during various breaks during work)


Solution
--------
- I used PHP 7
- I created Travis CI script to test the whole test-suite with PHP 7 and PHP 7.1
- In order to keep "production code" clear `YearlyReport.feature` was moved to `./features`.
- In order to change parameters per environment, I added `incenteev/composer-parameter-handler`
- In order to protect existing CLI commands during refactoring I started from integration tests of CLI commands:
    - `ReportYearlyCommandTest`
    - `TestDataResetCommandTest`
- I did not change too much in `TestDataResetCommandTest` because it is only for test purposes, but I added configurable input parameters
- I added transactions per 100 inserts for `TestDataResetCommandTest` to make it faster
- I added `year` input parameter for `ReportYearlyCommand`
- I extracted an interface for `YearlyReportQuery` because for case when I will want to use DoctrineORM or InMemory query I would like just add next implementation of an interface (open-close, interface-segregation)
- I created `DBALYearlyReportQuery`, and I'm able now to test each edge-case of `DBALYearlyReportQuery` in isolation, without `symfony/console`
- I added value objects: `MonthView` and `ProfileView` to easy manipulate with data
- Finally, I wrote acceptance test to confirm that YearlyReportQuery can work with console and MySQL DB and criteria's are fulfilled
- I extracted test suites (composer scripts):
    - `composer static-analysis` - CS-Fixer
    - `composer unit` - Unit test with PHPUnit
    - `composer integration` - Integration test suite with PHPUnit, to test integration of `symfony/console` with my code, and to test integration of `YearlyReportQuery` with a real database
    - `composer acceptance` - Test suite for confirming that everything can work together and acceptance criteria are filled
- I added indexes and keys to the schema in `setup.sql` (now query for 1 year with 10 views per day is a bit faster as well 195 ms vs 148 ms)
- I added executable `bin/setup-database` to setup DB in an automated way

