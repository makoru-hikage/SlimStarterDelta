<?php

class CourseSession extends Model {

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	protected $appends = [
		'semester', 
		'academic_year_held', 
		'academic_year_semester_held', 
		'course_code', 
		'instructor_full_name', 
		'instructor_number'
	];
	
	public function course(){
		return $this->hasOne('\\Course');
	}

	public function isGradedBy(){
		return $this->hasOne('\\Employee');
	}

	public function isRunDuring(){
		return $this->hasOne('\\SchoolCalendar');
	}

	public function studentsOfThis(){
		return $this->hasManyThrough('\\Student', '\\Enrollment');
	}

	public function getCourseCodeAttribute(){
		return Course::find($this->course_id)->code;
	}

	public function setCourseCodeAttribute($value){
		$this->course_id = Course::where('code', $value)->first()->id;
	}

	public function getAcademicYearHeldAttribute(){
		return SchoolCalendar::find($this->school_calendar_id)->academic_year;
	}

	public function getSemesterAttribute(){
		return SchoolCalendar::find($this->school_calendar_id)->semester;
	}

	public function getAcademicYearSemesterHeldAttribute(){
		return SchoolCalendar::find($this->school_calendar_id)->academic_year_semester;
	}

	public function getInstructorFullNameAttribute(){
		if ($this->employee_id > 0)
		return Employee::find($this->employee_id)->full_name;
	}

	public function getInstructorNumberAttribute(){
		if ($this->employee_id > 0)
		return Employee::find($this->employee_id)->employee_number;
	}

	public function setInstructorNumberAttribute($value){
		$this->employee_id = Employee::where('employee_number', $value)->first()->id;
		$this->save();
	}
}