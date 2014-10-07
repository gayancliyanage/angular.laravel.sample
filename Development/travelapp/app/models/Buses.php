<?php

class Buses extends Eloquent
{
	protected $table = 'buses';


	public function get_root_buses()
	{
		 $result = DB::table('buses')->get();
		 return $result;
	}


	public function get_root_options($start, $end){
		return	$result = DB::select('SELECT * FROM  `root_chains` WHERE  `bus_stop_id` IN ( '.$start.', '.$end.' )' );
	}


	public function get_buses($root_id)
	{
		return $result = DB::select('SELECT a.id as bus_id, a.root_id, d.name as last_stop , a.Heading, b.order, b.travel_time, b.distance, c.from_city, c.to_city, c.name 
										FROM buses as a 
										INNER JOIN 
											root_chains as b 
										ON 
											a.last_stop_id = b.bus_stop_id 
										INNER JOIN
										  roots as c
										ON
										  a.root_id = c.id
										INNER JOIN
										  bus_stops as d
										ON
										  a.last_stop_id = d.id
										WHERE a.root_id = '.$root_id.' GROUP BY a.id') ;
	}
}