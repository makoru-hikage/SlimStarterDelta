<?php

class Employee extends Model {

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];

	public function teaches(){
		return $this->hasManyThrough('\\Course','\\CourseSession');
	}
	
	public function userInfoOfThis(){
		$this->belongsTo('\\User');
	}

	public function isTheCurrentInfo(){
        return $this->morphMany('\\CurrentUserType', 'info');
    }

    public function getFullNameAttribute(){
    	if ($this->user_id > 0)
    	return User::find($this->user_id)->full_name;
    }
}