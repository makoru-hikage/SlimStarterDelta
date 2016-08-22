<?php
use Carbon\Carbon;

class SchoolCalendar extends Model {

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	protected $appends = ['academic_year', 'academic_year_semester'];

	protected $table = 'school_calendar';

	public function sessionsDuringThis(){
		return $this->hasMany('\\CourseSession');
	}

	public function getAcademicYearAttribute(){

		$possible_year_start = $this->date_start;
		$possible_year_end = $this->date_end;

		$academic_year = 
		SchoolCalendar::selectRaw('CONCAT(YEAR(MIN(date_start)),"-",YEAR(MAX(date_end))) AS ay')
		->where(function($q){
			$q->whereYear('date_start', '=', $this->date_start)
			->whereYear('date_end', '>=', $this->date_end)
			->whereYear('date_end', '<=', ($this->date_end)+1, 'or');
			})
		->first()->ay;

		return $academic_year;
	}

	public function getAcademicYearSemesterAttribute(){
		return $this->academic_year . ", " . $this->semester; ;
	}
}