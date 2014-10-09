<?php

class BusController extends BaseController {

	/**
	* get near by buses - inputs start stop_id and end_stop_id
	**/
	public function near_by_buses($start, $end)
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
	}

	/**
	* get bus details by bus_id
	**/
	public function get_bus_details($id){

		$buses = new Buses;

		$results = $buses->get_bus_detials($id);

		return Response::json($results);
	}

    /**
    * get near by bus stops by lattitude and longitude
    **/
	public function get_nearby_stops($lat, $lng){
		
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
	}

	/**
	* get routing options
	**/
	public function get_routing_options($start){

		$root_chains = new RootChains;

		$results = $root_chains->get_routing_options($start);

		return Response::json($results);
	}
}
