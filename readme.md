## Knipster API
Project url: [Knipster api](http://knipster.ga/api).

## Installation

- Clone this repo to directory on your server
- Run "composer install" and install all needed dependencies
- Rename .env.example file to .env and specify your database connection details
- Run migrations by "php artisan migrate"
- Run migrations for test db "php artisan migrate --database=testing_db"
- Generate app key by "php artisan key:generate"
- To run unit test just execute this command "vendor/bin/phpunit tests/Unit"
- For laravel dependent staff visit this link [Laravel installation]( https://laravel.com/docs/5.4/installation)

## API methods

---
 
 URL | HTTP-method | Description | Input
 --- | --- | --- | --- 
`knipster.ga/api/user` | POST | Creates user|``email``(required) - Email, ``country``(required) - Country, ``first_name`` - First name, ``last_name`` - Last name, ``gender`` - Gender
`knipster.ga/api/user/{id}` | PUT/PATCH | Updates user|``email`` - Email, ``country`` - Country, ``first_name`` - First name, ``last_name`` - Last name, ``gender`` - Gender
`knipster.ga/api/user/balance/deposit` | POST | Replenish user's balance|``user_id``(required) - User id, ``amount``(required) - Amount
`knipster.ga/api/user/balance/widraw` | POST | Withdraw money|``user_id``(required) - User id, ``amount``(required) - Amount
`knipster.ga/api/financial-operations` | GET | Withdraw/Deposit operations report |``date_start`` - Start range date. Date in 'Y-m-d' format,``date_end`` - End range date. Date in 'Y-m-d' format
