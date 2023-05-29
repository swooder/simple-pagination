<?php

namespace Swooder\SimplePagination;

use Illuminate\Support\ServiceProvider;

class SimplePaginationServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'simplepagination');
    }
}
