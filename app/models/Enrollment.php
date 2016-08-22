<?php

class Enrollment extends Model {

	protected $table = "enrollment";

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	protected $appends = [
		'student_full_name', 
		'course_taken',
		'academic_year_taken',
		'academic_year_semester_taken',
		'remark'
	];

	public function enrolledStudent(){
		return $this->hasOne('\\Student');
	}

	public function infoOfEnrolledStudent(){
		return Student::userInfo()->where('user_id', '=', $this->enrolledStudent());
	}

	public function courseSession(){
		return $this->hasOne('\\CourseSession');
	}
	
	public function enrolledCourse(){
		return CourseSession::course()->where('user_id', '=', $this->courseSession());
	}

	public function getCourseTakenAttribute(){
		return Curricula::find($this->curriculum_id)->course_code;
	}

	public function getStudentFullNameAttribute(){
		if ($this->student_id > 0)
		return Student::find($this->student_id)->full_name;
	}

	public function getStudentNumberAttribute(){
		if ($this->student_id > 0)
		return Student::find($this->student_id)->student_number;
	}

	public function setStudentNumberAttribute($value){
		$this->student_id = Student::where('student_number', $value)->first()->id;
		$this->save();
	}

	public function getAcademicYearTakenAttribute(){
		return CourseSession::find($this->course_session_id)->academic_year_held;
	}

	public function getAcademicYearSemesterTakenAttribute(){
		return CourseSession::find($this->course_session_id)->academic_year_semester_held;
	}

	public function getRemarkAttribute(){
		return Remark::find($this->remark_id)->remark;
	}

}