<?php

return array(
	'routes' => array(
		array('view-article', '(/<id>)', array(
				'controller' => 'article',
				'action' => 'view'
			)
		),
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
		array('default', '(/<controller>(/<action>(/<id>)))', array(
				'controller' => 'article',
				'action' => 'view'
			)
		)
	),
	'modules' => array('database', 'orm','email')
);
