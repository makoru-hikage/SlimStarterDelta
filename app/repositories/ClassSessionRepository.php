<?php

namespace Aegis\Repositories;

use \Prjkt\Component\Repofuck\Repofuck;

class ClassSessionRepository extends Repofuck {

	protected $resources = ['PersonRepository', 'SchoolCalendar', 'CourseSession'];
}