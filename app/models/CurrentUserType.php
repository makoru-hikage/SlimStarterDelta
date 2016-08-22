<?php

class CurrentUserType extends Model{
	
	protected $primaryKey = 'user_id';

	public function info(){	
        return $this->morphTo();
    }

}