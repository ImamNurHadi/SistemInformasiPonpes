<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Heroku DATABASE_URL Parser for PostgreSQL
        if (env('DATABASE_URL')) {
            try {
                $url = parse_url(env('DATABASE_URL'));
                
                Config::set('database.default', 'pgsql');
                Config::set('database.connections.pgsql.host', $url['host'] ?? null);
                Config::set('database.connections.pgsql.port', $url['port'] ?? null);
                Config::set('database.connections.pgsql.database', substr($url['path'] ?? '', 1));
                Config::set('database.connections.pgsql.username', $url['user'] ?? null);
                Config::set('database.connections.pgsql.password', $url['pass'] ?? null);
                Config::set('database.connections.pgsql.sslmode', 'require');
                
                // Backward compatibility with putenv
                putenv('DB_HOST='.$url['host']);
                putenv('DB_PORT='.$url['port']);
                putenv('DB_USERNAME='.$url['user']);
                putenv('DB_PASSWORD='.$url['pass']);
                putenv('DB_DATABASE='.substr($url['path'], 1));
                
                // Debug info
                if (env('APP_DEBUG')) {
                    Log::debug('Database configuration set via DATABASE_URL');
                }
            } catch (\Exception $e) {
                Log::error('Error parsing DATABASE_URL: ' . $e->getMessage());
            }
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
        
        // Enable CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        
        // Menghindari error "specified key was too long" di MariaDB/MySQL
        Schema::defaultStringLength(191);
        
        // Error handling untuk debugging
        if (env('APP_DEBUG')) {
            DB::listen(function($query) {
                Log::debug($query->sql, [
                    'bindings' => $query->bindings,
                    'time' => $query->time
                ]);
            });
        }
    }
}
