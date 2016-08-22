<?php

class CurriculumSemester extends Model {

	protected $guarded = ['created_at', 'updated_at', 'is_deleted'];
	protected $hidden = ['created_at', 'updated_at', 'is_deleted'];
	protected $appends = ['degree_code'];


    public function searchByDegreeAndSemester($degree_code, $year_level = null, $semester = null){
    	$q = new self;
    	$q = $degree_code ? $q->where('degree_id', Degree::where('code', $degree_code)->first()->id) : null;
    	$q = $year_level ? $q->where('year_level', $year_level) : $q;
    	$q = $semester ? $q->where('semester', $semester) : $q;

    	return $q;
    }

    public function getDegreeCodeAttribute(){
    	return Degree::find($this->degree_id)->code;
    }

}