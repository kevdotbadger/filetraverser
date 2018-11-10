<?php

namespace KevinRuscoe\FileTraverser;

use Illuminate\Support\ServiceProvider;

class FileTraverserServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('FileTraverser', function () {
            return $this->app->make('KevinRuscoe\FileTraverser\FileTraverser');
        });
    }
}
