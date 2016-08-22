<?php

class Student extends Model {

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	protected $hidden = ['created_at', 'updated_at', 'is_deleted'];

	protected $appends = ['degree_code', 'degree_name', 'degree_name_code','full_name'];

	public function degree(){
		return $this->belongsTo('\\Degree');
	}

	public function userInfo(){
		return $this->belongsTo('\\User');
	}

	public function isEnrolledIn(){
		return $this->hasManyThrough('\\CourseSessions','\\Enrollment');
	}

	public function currentStudents(){
        return $this->morphOne('\\CurrentUserType', 'info');
    }
    
    public function setDegreeIdAttribute($value){
        $this->degree_id = Degree::where('code', $value)->first()->id;
        $this->save();
    }

    public function getDegreeCodeAttribute(){
    	return Degree::find($this->degree_id)->code;
    }

    public function getDegreeNameAttribute($value){
        return Degree::find($this->degree_id)->name;
    }

    public function getDegreeNameCodeAttribute(){
        return $this->degree_name . " (" . $this ->degree_code . ")";
    }

    public function getFullNameAttribute(){
        if ($this->user_id > 0)
        return User::find($this->user_id)->full_name;
    }


}