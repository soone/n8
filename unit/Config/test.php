<?php
$pConfig['router'] = array(
	'type' => 1,
	'defControl' => 'home',
	'defAction' => 'index',
	'Home' => array(
		'index' => array(
			'id' => '/^',
		),
		'acs' => array('index'),
	),
);
