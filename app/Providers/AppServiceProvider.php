<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Heroku DATABASE_URL Parser for PostgreSQL
        if (env('DATABASE_URL')) {
            $url = parse_url(env('DATABASE_URL'));
            
            Config::set('database.default', 'pgsql');
            Config::set('database.connections.pgsql.host', $url['host']);
            Config::set('database.connections.pgsql.port', $url['port']);
            Config::set('database.connections.pgsql.database', substr($url['path'], 1));
            Config::set('database.connections.pgsql.username', $url['user']);
            Config::set('database.connections.pgsql.password', $url['pass']);
            
            // Backward compatibility with putenv
            putenv('DB_HOST='.$url['host']);
            putenv('DB_PORT='.$url['port']);
            putenv('DB_USERNAME='.$url['user']);
            putenv('DB_PASSWORD='.$url['pass']);
            putenv('DB_DATABASE='.substr($url['path'], 1));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Menghindari error "specified key was too long" di MariaDB/MySQL
        Schema::defaultStringLength(191);
    }
}
