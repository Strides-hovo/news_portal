# Laravel Docker Environment

A complete Docker environment for Laravel applications with Nginx, PHP-FPM, MySQL, RabbitMQ, and Supervisor.

## Services

- **Nginx** - Alpine, web server
- **PHP** - 8.2-FPM with extensions
- **MySQL** - Version 8
- **RabbitMQ** - With management interface
- **Supervisor** - For managing Laravel queue workers
- **Additional Tools** - Composer, Git, npm

## Directory Structure

```
.
├── docker/
│   ├── nginx/
│   │   ├── Dockerfile
│   │   └── default.conf
│   ├── php/
│   │   ├── Dockerfile
│   │   └── php.ini
│   ├   ── supervisor/
│   │       ├── Dockerfile
│   │       └── supervisord.conf
│   ├           conf.d/
│   │       └── laravel-worker.conf
│   ├── supervisor/
│   │   ├── Dockerfile
│   │   ├── supervisord.conf
│   │   └── conf.d/
│   │       └── laravel-worker.conf
│   └── mysql/
│       ├── my.cnf
│       └── init/
         mysql_data/
├── src/                    # Laravel application code goes here
├── .env                    # Environment variables
└── docker-compose.yml      # Docker Compose configuration
```




## Accessing Services

- **Web**: http://localhost
- **RabbitMQ Management**: http://localhost:15672
- **MySQL**: localhost:3306

## Useful Commands

```bash
# Build Frontend vs Backend containers
npm run build

# Stop all containers
composer install

# Remove all containers
php artisan migrate
```

## Configuration

You can modify service configurations in the following files:

- Nginx: `docker/nginx/default.conf`
- PHP: `docker/php/php.ini`
- MySQL: `docker/mysql/my.cnf`
- Supervisor: `docker/supervisor/conf.d/*.conf`

## Adding Laravel Code
[README.md](..%2Fnews_portal%2FREADME.md)
Laravel project in  `src` directory:



2. **Supervisor**
```bash
   [program:rabbit_consumer]
   command=php artisan schedule:work
   numprocs=1  
   process_name=%(program_name)s
   autorestart=true
```
3. Reverb
```bash
  [program:reverb_start]
   command=php artisan reverb:start
   numprocs=1  
   process_name=%(program_name)s
   autorestart=true
```