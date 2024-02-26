# How to setup
1. Clone repository `git clone https://github.com/adamchrabaszcz/payroll-tidio.git`
1. Install dependencies `composer install` 
1. Launch docker with `docker-compose up --build`
1. Enter docker php container
1. Launch migrations `bin/console doctrine:migrations:migrate`
1. Create Department(s) `bin/console app:department:create`
1. Create Employee(s) `bin/console app:employee:create`

# Generate Report
1. Generate Payroll Report `bin/console app:payroll-report`

# Launch tests
1. Unit tests `bin/phpunit --stop-on-failure --testdox -v`

# Enjoy!