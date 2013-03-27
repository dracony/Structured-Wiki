<?php

return array(
	'routes' => array(
		array('view-template', '/!<id>', array(
				'controller' => 'template',
				'action' => 'view'
			)
		),
		array('edit-template', '/edit/!<id>', array(
				'controller' => 'template',
				'action' => 'edit'
			)
		),
		array('talk-template', '/talk/!<id>', array(
				'controller' => 'template',
				'action' => 'talk'
			)
		),
		array('edit-article', '/edit/<id>', array(
				'controller' => 'article',
				'action' => 'edit',
				'id' => 'Welcome'
			)
		),
		array('talk-article', '/talk/<id>', array(
				'controller' => 'article',
				'action' => 'talk',
				'id' => 'Welcome'
			)
		),
		array('app-install', '/~installer(/<action>)', array(
				'controller' => 'installer',
				'action' => 'start'
			)
		),
		array('app-api', '/~api(/<command>)', array(
				'controller' => 'api',
				'command' => 'help'
			)
		),
		array('view-article', '(/<id>)', array(
				'controller' => 'article',
				'action' => 'view',
				'id' => 'Welcome'
			)
		)
	),
	'modules' => array('database', 'orm','migrate')
);
