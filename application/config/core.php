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
		array('app-install', '/~installer(/<action>)', array(
				'controller' => 'installer',
				'action' => 'start'
			)
		),
		array('app-api', '/~api(/<command>)', array(
				'controller' => 'api',
				'action' => 'api'
			)
		),
		array('view-article', array('(/<id>)',array('id'=>'.*+')), array(
				'controller' => 'article',
				'action' => 'view'
			)
		)
	),
	'modules' => array('database', 'orm','migrate')
);
