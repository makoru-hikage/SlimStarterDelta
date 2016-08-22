<?php

class Curriculum extends Model {

	protected $table = 'curricula';

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	protected $appends = ['semester', 'year_level', 'degree_code', 'course_code'];

	public function prerequisiteSetOfThis(){	
		$this->hasOne('\\PrerequisiteSet');
	}

	public function degreeWhereThisBelongs (){
		return $this->hasManyThrough('\\Degree', '\\CurriculumSemester');
	}

	/**
	 * One must use this query to see the courses that must be enrolled and passed to complete a degree. 
	 */
	public static function blankChecklist(){
		return Degree::join('curriculum_semesters','curriculum_semesters.degree_id', '=', 'degrees.id')
		->join('curricula','curricula.curriculum_semester_id', '=', 'curriculum_semesters.id')
		->leftJoin('courses','curricula.course_id', '=', 'courses.id')
		->leftJoin('prerequisite_sets','curricula.prerequisite_set_id', '=', 'prerequisite_sets.id')
		->leftJoin('prerequisite_courses','prerequisite_courses.prerequisite_set_id', '=', 'prerequisite_sets.id');

	}

	/**
	 * One must use this query if the student is officially enrolled to a degree.
	 */
	public static function filledChecklist(){
		return Curriculum::blankChecklist()
		->leftJoin('enrollment', 'curricula.id', '=', 'enrollment.curriculum_id')
		->leftJoin('course_sessions','course_sessions.id', '=', 'enrollment.course_session_id')
		->leftJoin('employees','course_sessions.employee_id', '=', 'employees.id')
		->leftJoin('users','employees.user_id', '=', 'users.id')
		->leftJoin('school_calendar', 'course_sessions.school_calendar_id', '=', 'school_calendar.id');
	}

	public static function degreeChecklist($degree_id){
		return Curriculum::blankChecklist()->where('curriculum_semesters.degree_id', $degree_id);
	}

	public static function findChecklistByStudentId($student_id){
		return Curriculum::filledChecklist()->where('enrollment.student_id', $student_id);
	}

	public static function findChecklistByUserId($user_id){
		return Curriculum::filledChecklist()
			->whereIn('students.id', Student::where('user_id', $user_id)->lists('id'));
	}

	public function getSemesterAttribute(){
		return CurriculumSemester::find($this->curriculum_semester_id)->semester;
	}

	public function getYearLevelAttribute(){
		return CurriculumSemester::find($this->curriculum_semester_id)->year_level;
	}

	public function getDegreeCodeAttribute(){
		return Degree::find(CurriculumSemester::find($this->curriculum_semester_id)->degree_id)->semester;
	}

	public function getCourseCodeAttribute(){
		return Course::find($this->course_id)->code;
	}

	public function setCourseCodeAttribute($value){
		$this->course_id = Course::where('code', $value)->first()->id;
		$this->save();
	}
}