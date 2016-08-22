<?php

namespace Aegis\Repositories;

use \Prjkt\Component\Repofuck\Repofuck;

class ChecklistRepository extends Repofuck {

	protected $resources = ['AcademicProgramRepository', 'PersonRepository', 'Remark'];
	
}