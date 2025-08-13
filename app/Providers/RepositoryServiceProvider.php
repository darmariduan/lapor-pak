<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ResidentRepository;
use App\Interfaces\AuthRepositoryInterface;
use App\Repositories\ReportCategoryRepository;
use App\Interfaces\ResidentRepositoryInterface;
use App\Interfaces\ReportCategoryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ResidentRepositoryInterface::class, ResidentRepository::class);
        $this->app->bind(ReportCategoryRepositoryInterface::class, ReportCategoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
