<?php
return array(
	'view-template' => array('/!<id>', array(
				'controller' => 'template',
				'action' => 'view'
			)
		),
	'edit-template' => array('/edit/!<id>', array(
				'controller' => 'template',
				'action' => 'edit'
			)
		),
	'talk-template' => array('/talk/!<id>', array(
				'controller' => 'template',
				'action' => 'talk'
			)
		),
	'edit-article' => array('/edit/<id>', array(
				'controller' => 'article',
				'action' => 'edit',
				'id' => 'Welcome'
			)
		),
	'talk-article' => array('/talk/<id>', array(
				'controller' => 'article',
				'action' => 'talk',
				'id' => 'Welcome'
			)
		),
	'app-install' => array('/~installer(/<action>)', array(
				'controller' => 'installer',
				'action' => 'start'
			)
		),
	'app-api' => array('/~api(/<command>)', array(
				'controller' => 'api',
				'command' => 'help',
				'action' => 'api'
			)
		),
	'view-article' => array('(/<id>)', array(
				'controller' => 'article',
				'action' => 'view',
				'id' => 'Welcome'
			)
		)
);
