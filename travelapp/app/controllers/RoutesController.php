<?php

class RoutesController extends BaseController {

    /**
    * get list of bus stops
    */
	public function get_bus_stops(){
		
		$bus_stops = new BusStops;

		$results = $bus_stops->get_bus_stops();

		return Response::json($results);
	}

	/**
	* get list of bus roots
	*/
	public function get_bus_roots(){
		
		$root = new Root;

		$results = $root->get_bus_roots();

		return Response::json($results);
	}

	/**
	* get bus root details by di
	*/
	public function get_bus_root_details($id){

		$root = new Root;

		$results = $root->get_bus_root_details($id);

		return Response::json($results);
	}
}
