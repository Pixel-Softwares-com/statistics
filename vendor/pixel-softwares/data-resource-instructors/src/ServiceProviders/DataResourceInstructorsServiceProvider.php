<?php

namespace DataResourceInstructors\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class DataResourceInstructorsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes(
            [__DIR__ . "/../../config/data-resource-instructors-config.php" => config_path("data-resource-instructors-config.php") ] ,
            'data-resource-instructors-config'
        );

    }

}
