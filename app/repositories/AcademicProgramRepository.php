<?php

namespace Aegis\Repositories;

use \Prjkt\Component\Repofuck\Repofuck;

class AcademicProgramRepository extends Repofuck {

	protected $resources = ['Degree', 'Course', 'Curriculum', 'PrerequisiteCourse', 'PrerequisiteSet'];
	
}