<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Livewire;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any modular application services.
     */
    public function boot(): void
    {
        $modulesBasePath = app_path('Modules');

        if (! File::isDirectory($modulesBasePath)) {
            return;
        }

        foreach (File::directories($modulesBasePath) as $modulePath) {
            $moduleName = basename($modulePath);
            $moduleKey = Str::kebab($moduleName);

            $routesFile = "{$modulePath}/routes.php";
            if (File::exists($routesFile)) {
                Route::middleware('web')->group($routesFile);
            }

            $viewsPath = "{$modulePath}/Views";
            if (File::isDirectory($viewsPath)) {
                View::addNamespace($moduleKey, $viewsPath);
            }

            $livewireClassPath = "{$modulePath}/Livewire";
            $livewireViewPath = File::isDirectory("{$viewsPath}/livewire")
                ? "{$viewsPath}/livewire"
                : $viewsPath;

            if (File::isDirectory($livewireClassPath) || File::isDirectory($viewsPath)) {
                Livewire::addNamespace(
                    namespace: $moduleKey,
                    viewPath: File::isDirectory($viewsPath) ? $livewireViewPath : null,
                    classNamespace: "App\\Modules\\{$moduleName}\\Livewire",
                    classPath: $livewireClassPath,
                    classViewPath: File::isDirectory($viewsPath) ? $livewireViewPath : null,
                );
            }
        }
    }
}
