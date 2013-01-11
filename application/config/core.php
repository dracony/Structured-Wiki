<?php

return array(
	'routes' => array(
		array('edit-article', '/edit(/<id>)', array(
				'controller' => 'article',
				'action' => 'edit'
			)
		),
		array('talk-article', '/talk(/<id>)', array(
				'controller' => 'article',
				'action' => 'talk'
			)
		),
		array('app-install', '/installer(/<action>)', array(
				'controller' => 'installer',
				'action' => 'start'
			)
		),
		array('view-article', '(/<id>)', array(
				'controller' => 'article',
				'action' => 'view'
			)
		),
		array('default', '(/<controller>(/<action>(/<id>)))', array(
				'controller' => 'article',
				'action' => 'index'
			)
		)
	),
	'modules' => array('database', 'orm','email')
);
