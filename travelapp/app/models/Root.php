<?php

class Root extends Eloquent
{
	protected $table = 'roots';

	public function buses()
    {
        return $this->hasMany('Buses','root_id','id');
    }
    
}