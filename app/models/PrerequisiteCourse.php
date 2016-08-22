<?php

class PrerequisiteCourse extends Model {

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	protected $appends = ['course_code'];

	public function coursesNeeded(){
		return $this->hasOne('\\Course');
	}

	public function prerequisiteSet(){
		return $this->belongsTo('\\PrerequisiteSet');
	}

	public function getCourseCodeAttribute(){
		return Course::where('id', $this->curriculum()->first()->course_id)->value('code');
	}

	public function setCourseCodeAttribute($value){
		$course = Course::find($this->curriculum()->first()->course_id);
		$course->code = $value;
		$course->save();
	}
}