# cinema test app

## Project Installation

### Requirements
- Docker
- GIT CLI

#### Using Docker Commands

There are 2 docker compose config files
**docker-compose.local.yml** - Use image with local MySQL installation
**docker-compose.yml** - Use image with external MySQL server

1. Clone The Project
2. Replace ENV Values in **.env** file
3. Run `docker compose -f docker-compose.local.yml pull`
4. Run `docker compose -f docker-compose.local.yml build --pull`
5. Run `docker compose -f docker-compose.local.yml up -d`
6. Install Composer Deps. Run `docker compose -f docker-compose.local.yml run --rm cinema_test_php composer install`
7. Run Migrations. `docker compose -f docker-compose.local.yml run --rm cinema_test_php php artisan migrate`
8. Run Seeders. `docker compose -f docker-compose.local.yml run --rm cinema_test_php php artisan db:seed`

## Environment Variables

- `NGINX_HOST_PORT` - Forwarded API Port.

- `DB_HOST_PATH` - Folders For Storing Docker's DB Files. Default: `database`;
- `DB_ROOT_PASSWORD` - Local Database Password;
- `DB_HOST_PORT` - Forwarded Host's Local DB Port;

- `DB_EXTERNAL_HOST` - External Database Host;
- `DB_EXTERNAL_DATABASE` - External Database Name;
- `DB_EXTERNAL_USERNAME` - External Database Username;
- `DB_EXTERNAL_PASSWORD` - External Database Password;
- `DB_EXTERNAL_PORT` - Forwarded External DB Port;

## Local Database 

- User: `root`
- Database: `cinema_test`
- Password: Value Of `DB_ROOT_PASSWORD` ENV Variable


## TODO:

- Create a helper bash script to simplify running different commands (docker compose) taking into account the environment (local or prod)
- Write more test cases