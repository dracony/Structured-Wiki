<?php
return array(
    // System table, holds general key=value pairs
    'system' => array (
		'id' => array (
			'type' => 'id'
		),
		'name' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'value' => array(
			'type' => 'varchar',
			'size' => 255
		)
	),
	
	'users' => array (
	    'id' => array (
	        'type' => 'id'
	    ),
		'email' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'nickname' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'passwordHash' => array(
			'type' => 'varchar',
			'size' => 255
		),
		'lastLogon' => array(
			'type' => 'date'
		),
		'lastIP' => array(
			'type' => 'varchar',
			'size' => 15
		)
	)
);