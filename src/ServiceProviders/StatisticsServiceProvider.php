<?php

namespace Statistics\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class StatisticsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes(
            [__DIR__ . "/../../config/statistics-config.php" => config_path("statistics-cache-config.php") ] ,
            'statistics-cache-config'
        );

    }

}
