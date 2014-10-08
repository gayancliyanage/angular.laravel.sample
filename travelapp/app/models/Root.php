<?php

class Root extends Eloquent
{
	protected $table = 'roots';

	public function get_bus_roots()
	{
		$result = DB::select("SELECT id, name, from_city, to_city FROM roots");
		return $result;
	}

	public function get_bus_root_details($id)
	{
		$result = DB::select("SELECT a.id, c.id as root_id, a.Heading, b.name as last_stop, c.name as rootname, c.from_city, c.to_city FROM buses as a 
							 INNER JOIN bus_stops as b							 
							 ON a.last_stop_id=b.id
							 INNER JOIN roots as c
							 ON a.root_id=c.id
							 WHERE root_id =".$id);
		return $result;
	}

	
    
    
}