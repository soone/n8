<?php
require_once 'PHPUnit/Framework.php';
class n8CommonParseTest extends PHPUnit_Framework_TestCase
{
	public $conf;

	protected function setUp()
	{
		global $_REQUEST;
		defined('N8_ROOT') ? '' : define('N8_ROOT', '/media/work/code/N8/');
		defined('PROJECT_CONFIG') ? '' : define('PROJECT_CONFIG', N8_ROOT . 'unit/');
		defined('PROJECT_NAME') ? '' : define('PROJECT_NAME', 'test');
		defined('PROJECT_ROOT') ? '' : define('PROJECT_ROOT', dirname(dirname(__FILE__)) . '/');//项目地址
		require_once N8_ROOT . './Config.php';
		$this->conf = new N8_Config(PROJECT_CONFIG . '/' . PROJECT_NAME . '.php');
		require_once N8_ROOT . './Router/CommonParse.php';
		$this->obj = new N8_Router_CommonParse();
		$_REQUEST['control'] = 'home';
		$_REQUEST['action'] = 'index';
		$_GET['id'] = 102394;
		$_GET['token'] = 'fd78fddsaf6g6fd79g06';
		$this->obj->parse($this->conf);
	}

	protected function tearDown()
	{
		//$this->obj = null;
		//$this->conf = null;
	}

	public function testGetControl()
	{
		$this->assertEquals('Home', $this->obj->getControl());
	}

	public function testGetAction()
	{
		$this->assertEquals('index', $this->obj->getAction());
	}

	public function testGetGet()
	{
		$get = $this->obj->getGet();
		$this->assertEquals('102394', $get['id']);
		$this->assertEquals('fd78fddsaf6g6fd79g06', $get['token']);
	}
}
