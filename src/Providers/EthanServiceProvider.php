<?php

namespace Ethan\LaravelAdmin\Providers;


use Ethan\LaravelAdmin\Console\NotificationSocket;
use Illuminate\Support\ServiceProvider;
use Ethan\LaravelAdmin\Console\InstallCommand;


class EthanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->registerModelFilters();

            $this->registerMigrations();

            $this->registerMiddleware();

            $this->commands([
                InstallCommand::class,
                NotificationSocket::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function registerModelFilters()
    {
        $modelFiltersPath = __DIR__ . '/../Filters/';

        $items = [
            'AdminUserFilter.php',
            'MenuFilter.php',
            'PermissionFilter.php',
            'PermissionGroupFilter.php',
            'RoleFilter.php',
        ];

        $paths = [];
        foreach ($items as $key => $name) {
            $paths[$modelFiltersPath . $name] = 'app/ModelFilters' . "/" . $name;
        }

        $this->publishes($paths, 'modelFilters');
    }

    private function registerMigrations()
    {
        $migrationsPath = __DIR__ . '/../Database/migrations/';

        $items = [
            'add_field_permission_table.php',
            'create_admin_users_table.php',
            'menus_table.php',
            'permission_groups_table.php'
        ];

        $paths = [];
        foreach ($items as $key => $name) {
            $paths[$migrationsPath . $name] = database_path('migrations') . "/" . date('Y_m_d_His', time() + $key + count($items)) . '_' . $name;
        }

        $this->publishes($paths, 'migrations');
    }

    private function registerMiddleware()
    {
        $modelFiltersPath = __DIR__ . '/../Http/Middleware/';

        $items = [
            'EthanAuthCanPermission.php'
        ];

        $paths = [];
        foreach ($items as $key => $name) {
            $paths[$modelFiltersPath . $name] = 'app/Http/Middleware' . "/" . $name;
        }

        $this->publishes($paths, 'middleware');
    }
}