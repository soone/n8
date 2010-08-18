<?php
$pConfig['router'] = array(
	'type' => 1,
	'defControl' => 'home',
	'defAction' => 'index',
	'Home' => array(
		'index' => array(
			'regex' => '/\/(.*)\/(.*)/i',
			'keys' => array('id', 'token')
		),
		'acs' => array('index'),
	),
	'Test2' => array(
		'index' => array(
			'regex' => '/.*\/(.*)\/(.*)/i',
			'keys' => array('id', 'token')
		),
		'acs' => array('index', 'x1'),
	),
	'Test3' => array(
		'index' => array(
			'regex' => '/.*\/(.*)\/(.*)/i',
			'keys' => array('id', 'token')
		),
		'acs' => array('index', 'x1'),
	),
);
