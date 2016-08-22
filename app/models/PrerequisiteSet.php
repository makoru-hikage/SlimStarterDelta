<?php

class PrerequisiteSet extends Model {

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	protected $appends = ['course_code'];

	public function courses(){
		return $this->hasManyThrough('\\Courses', '\\PrerequisiteSubjects');
	}

	public function curriculum(){
		return $this->hasMany('\\Curriculum');
	}

}