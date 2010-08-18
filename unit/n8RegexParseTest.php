<?php
require_once 'PHPUnit/Framework.php';
class n8RegexParseTest extends PHPUnit_Framework_TestCase
{
	public $conf;

	protected function setUp()
	{
		global $_SERVER;
		defined('N8_ROOT') ? '' : define('N8_ROOT', '/media/work/code/N8/');
		defined('PROJECT_CONFIG') ? '' : define('PROJECT_CONFIG', N8_ROOT . 'unit/');
		defined('PROJECT_NAME') ? '' : define('PROJECT_NAME', 'test');
		defined('PROJECT_ROOT') ? '' : define('PROJECT_ROOT', dirname(dirname(__FILE__)) . '/');//项目地址
		require_once N8_ROOT . './Config.php';
		$this->conf = new N8_Config(PROJECT_CONFIG . '/' . PROJECT_NAME . '.php');
		require_once N8_ROOT . './Router/RegexParse.php';
		$this->obj = new N8_Router_RegexParse();
	}

	public function testGetControl()
	{
		$_SERVER['REQUEST_URI'] = '/RegexParseTest/test1';
		$this->obj->parse($this->conf);
		$this->assertEquals('Home', $this->obj->getControl());
		$_SERVER['REQUEST_URI'] = '/test2/';
		$this->obj->parse($this->conf);
		$this->assertEquals('Test2', $this->obj->getControl());
	}

	public function testGetAction()
	{
		$_SERVER['REQUEST_URI'] = '/RegexParseTest/test1';
		$this->obj->parse($this->conf);
		global $_SERVER;
		$this->assertEquals('index', $this->obj->getAction());
		$_SERVER['REQUEST_URI'] = '/test2/x1/';
		$this->obj->parse($this->conf);
		$this->assertEquals('x1', $this->obj->getAction());
	}

	public function testGetGet()
	{
		$_SERVER['REQUEST_URI'] = '/RegexParseTest/test1';
		$this->obj->parse($this->conf);
		$get = $this->obj->getGet();
		$this->assertEquals('RegexParseTest', $get['id']);
		$this->assertEquals('test1', $get['token']);

		$_SERVER['REQUEST_URI'] = '/test2/10232/fasd98fd8a9asfd9';
		$this->obj->parse($this->conf);
		$get = $this->obj->getGet();
		$this->assertEquals('10232', $get['id']);
		$this->assertEquals('fasd98fd8a9asfd9', $get['token']);
		
		$_SERVER['REQUEST_URI'] = '/test3/x2/10232/fasd98fd8a9asfd9';
		$this->obj->parse($this->conf);
		$get = $this->obj->getGet();
		$this->assertEquals('10232', $get['id']);
		$this->assertEquals('fasd98fd8a9asfd9', $get['token']);
	}
}
