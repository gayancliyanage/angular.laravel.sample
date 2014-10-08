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
	Route::get('/', function()
	{
		App::abort(404, "Bad Input types");
		return View::make('index');	
    });


	Route::get('/nearby/{start}/{end}', function($start, $end)
	{
		if(!is_int($start) && !is_int($end))
		{
			return Response::json(array(
				'status'=>'404',
				'error' => "Bad request data",
			), 404);
			exit;
		}
		$buses = new Buses;

		$roots = $buses->get_root_options($start, $end); 
		$results_list = array();
		$temp_roots = array();

		foreach($roots as $root)
		{
			if($root->bus_stop_id == $start){
				$temp_start = $root;
			}else
			{
				$temp_end = $root;
			}
			if(!in_array($root->root_id, $temp_roots))
			{
				array_push($temp_roots, $root->root_id);
			}
		
		}

		foreach ($temp_roots as $temp_root) {
			if($temp_start->order < $temp_end->order)
			{
				$results = $buses->get_buses($temp_root);
				foreach ($results as $bus) {
					if($temp_start->order > $bus->order)
					{
						array_push($results_list, $bus);
					}
				}
			}
			else
			{
				$results = $buses->get_buses($temp_root);
				foreach ($results as $bus) {
					if($temp_start->order < $bus->order)
					{
						array_push($results_list, $bus);
					}
				}
			}
		}
		

		return Response::json($results_list);
	});

	Route::get('/bus_details/{id}',function($id){

		if(!is_int($id))
		{
			return Response::json(array(
				'status'=>'404',
				'error' => "Bad request data",
			), 404);
			exit;
		}

		$buses = new Buses;

		$results = $buses->get_bus_detials($id);

		return Response::json($results);
	});


	Route::get('/nearby_stops/{lat}/{lng}',function($lat, $lng){
		
		if(!is_numeric($lat) && !is_numeric($lat))
		{
			return Response::json(array(
				'status'=>'404',
				'error' => "Bad request data",
			), 404);
			exit;
		}

		$bus_stops = new BusStops;

		$results = $bus_stops->get_nearby_stops($lat,$lng);

		return Response::json($results);
	});


	Route::get('/routing_optoins/{start}',function($start){

		if(!is_int((int)$start))
		{
			return Response::json(array(
				'status'=>'404',
				'error' => "Bad request data",
			), 404);
			exit;
		}

		$root_chains = new RootChains;

		$results = $root_chains->get_routing_options($start);

		return Response::json($results);
	});


	Route::get('/buses', function()
	{
		var_dump($buses->get_root_buses());
	});


	Route::get('/bus_stops',function(){
		
		$bus_stops = new BusStops;

		$results = $bus_stops->get_bus_stops();

		return Response::json($results);
	});

	Route::get('/routes',function(){
		
		$root = new Root;

		$results = $root->get_bus_roots();

		return Response::json($results);
	});

	Route::get('/route_detials/{id}',function($id){

		if(!is_int($lat))
		{
			return Response::json(array(
				'status'=>'404',
				'error' => "Bad request data",
			), 404);
			exit;
		}

		$root = new Root;

		$results = $root->get_bus_root_details($id);

		return Response::json($results);
	});

	App::missing(function($exception)
	{
	   return Response::json(array(
	   			'status'=>'404',
				'error' => "Requested Service Not Found",
			), 404);
			exit;
	});