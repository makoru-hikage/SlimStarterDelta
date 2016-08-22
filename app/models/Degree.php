<?php

class Degree extends Model {

	protected $fillable = ['id', 'code', 'name', 'major'];
	protected $hidden = ['created_at', 'updated_at', 'is_deleted'];
	protected $appends = ['name_and_code'];
	
	public function curriculum(){
		return $this->hasManyThrough('\\Curriculum', '\\CurriculumSemester');
	}

	public function studentsOfThis(){
		return $this->hasManyThrough('\\Users','\\Students');
	}

	public function getNameAndCodeAttribute(){
		return $this->name . ' (' . $this->code .')';
	}

	public static function whereDegree($query, $id){
		$query->where('degrees.id', '=', $id);
	}

	
}