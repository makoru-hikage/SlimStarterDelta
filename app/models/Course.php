<?php

class Course extends Model {


	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	
	public function sessions(){
		return $this->hasMany('\\CourseSession');
	}

	public function curricula(){
		return $this->hasMany('\\Curriculum');
	}

	public function isNeededBy(){
		return $this->hasManyThrough('\\PrerequisiteSet','\\PrerequisiteCourses');
	}

	public function enrollmentsOfThis(){
		return $this->hasManyThrough('\\Enrollment','\\CourseSession');
	}

}