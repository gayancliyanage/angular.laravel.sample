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


	Route::get('/nearby/{start}/{end}', function($start, $end)
	{
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


	Route::get('/nearby_stops/{lat}/{lng}',function($lat, $lng){
		
		$bus_stops = new BusStops;

		$results = $bus_stops->get_nearby_stops($lat,$lng);

		return Response::json($results);
	});


	Route::get('/routing_optoins/{start}',function($start){

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