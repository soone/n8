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

/**
0-int类型
1-
*/
$pConfig['reqRule'] = array('User' => 
	array(
		'index' => array(
			'get' => array(
				'require' => array(
					'id' => FILTER_SANITIZE_ENCODED,
					'mIds' => array(
						'filter' => 'array',
						'flags' => 0,
						'range' => array(1, 20),
						'regex' => '/^fdas$/i',
						'msg' => '至少要选择一个'
					)
				),
				'options' => array(
					'email' => array(
						'filter' => 2,
						'default' => NULL,
					),
				)
			),
			'post' => array(),
			'cookie' => array(),
			'return' => '',
		)
	),
);

$args = array(
    'product_id'   => FILTER_SANITIZE_ENCODED,
	'component'    => array(
		'filter'    => FILTER_VALIDATE_INT,
		'flags'     => FILTER_REQUIRE_ARRAY, 
		'options'   => array('min_range' => 1, 'max_range' => 10),
		'msg' => 'test',
		'default' => '1' 
	),  
	'versions'     => FILTER_SANITIZE_ENCODED,
	'doesnotexist' => FILTER_VALIDATE_INT,
	'testscalar'   => array(
		'filter' => FILTER_VALIDATE_INT,
		'flags'  => FILTER_REQUIRE_SCALAR,
	),  
	'testarray'    => array(
		'filter' => FILTER_VALIDATE_INT,
		'flags'  => FILTER_REQUIRE_ARRAY,
	),  
	't2' => array(
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' => array('regexp' => '/^M(.*)$/')
	)   
);
