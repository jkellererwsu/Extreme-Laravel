<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);

       $router->model('contacts', 'App\contact');
        $router->model('groups', 'App\Group');
        $router->model('events', 'App\Event');
        $router->model('services', 'App\Service');
        $router->model('attendances','App\Attendance');
        $router->model('trainings', 'App\Training');

        $router->bind('tags', function($name)
        {
           return \App\Tag::where('name',$name)->firstOrFail();
        });
        $router->bind('positions', function($title)
        {
            return \App\Position::where('title',$title)->firstOrFail();
        });

        //$router->model('tags', 'App\Tag');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
