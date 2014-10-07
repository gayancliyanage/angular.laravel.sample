<?php

class RootChains extends Eloquent
{
	protected $table = "bus_stops";

	public function get_routing_options($start)
	{
		$results = DB::select( 'SELECT a.bus_stop_id, b.name, b.title FROM root_chains as a
									INNER JOIN
										  bus_stops as b
										ON
										  a.bus_stop_id = b.id
									WHERE a.bus_stop_id != '.$start.' AND
									 a.root_id IN (SELECT root_id FROM root_chains WHERE bus_stop_id = '.$start.') GROUP BY a.bus_stop_id');
		return $results;
	}
}
