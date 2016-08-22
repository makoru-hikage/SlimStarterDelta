<?php

namespace Aegis\Repositories;

use \Prjkt\Component\Repofuck\Repofuck;

class PersonRepository extends Repofuck {

	protected $resources = ['User', 'Student', 'Employee'];
}