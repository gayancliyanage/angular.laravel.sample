<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

	Route::filter('cache', function($route, $request, $response = null)
	{
	    $key = 'route-'.Str::slug(Request::url());
	    if(is_null($response) && Cache::has($key))
	    {
	        return Cache::get($key);
	    }
	    elseif(!is_null($response) && !Cache::has($key))
	    {
	        Cache::put($key, $response->getContent(), 3);
	    }
	});

 	Route::get('/', array('before' => 'cache', 'after' => 'cache', 'uses' => 'HomeController@showWelcome'));

 	Route::group( array('before' => 'cache', 'after' => 'cache'), function()
	{
    /**
    *BusController related routings
    *
    *
    **/
   
		Route::get('/nearby/{start}/{end}', 'BusController@near_by_buses');

		Route::get('/bus_details/{id}', 'BusController@get_bus_details');

		Route::get('/nearby_stops/{lat}/{lng}','BusController@get_nearby_stops');

		Route::get('/routing_optoins/{start}','BusController@get_routing_options');	

	/**
    *RoutesController related routings
    *
    *
    **/

	Route::get('/bus_stops','RoutesController@get_bus_stops');

	Route::get('/routes','RoutesController@get_bus_roots');

	Route::get('/route_detials/{id}','RoutesController@get_bus_root_details');
	});

	App::missing(function($exception)
	{
	   return Response::json(array(
	   			'status'=>'404',
				'error' => "Requested Service Not Found",
			), 404);
			exit;
	});