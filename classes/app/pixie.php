<?php

namespace App;

/**
 * Pixie dependency container
 *
 * @property-read \PHPixie\DB $db Database module
 * @property-read \PHPixie\ORM $orm ORM module
 */
class Pixie extends \PHPixie\Pixie {
	protected $modules = array(
		'db' => '\PHPixie\DB',
		'orm' => '\PHPixie\ORM',
		'migrate' => '\PHPixie\Migrate'
	);
	
	public $util;
	
	public function after_bootstrap() {
		$this->util = new Util;
	}
}