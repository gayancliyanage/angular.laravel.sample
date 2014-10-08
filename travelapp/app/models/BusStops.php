<?php

class BusStops extends Eloquent
{
	protected $table = "bus_stops";

	public function get_nearby_stops($lat,$lng){

		$results = DB::select('SELECT a.id, a.name , a.lat, a.lng,
		   111.1111 *
		    DEGREES(ACOS(COS(RADIANS(a.lat))
		         * COS(RADIANS('.$lat.'))
		         * COS(RADIANS(a.lng - '.$lng.'))
		         + SIN(RADIANS(a.lat))
		         * SIN(RADIANS('.$lat.')))) AS distance_in_km 
		  FROM bus_stops AS a ORDER BY distance_in_km LIMIT 8');

		return $results;
	}

	public function get_bus_stops(){
		return $result = DB::select('SELECT a.id,a.name,a.title FROM bus_stops as a');
	}
}