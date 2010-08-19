<?php
require_once 'PHPUnit/Framework.php';
class n8MemcacheTest extends PHPUnit_Framework_TestCase
{
	public $conf;
	public $obj;

	protected function setUp()
	{
		global $_REQUEST;
		defined('N8_ROOT') ? '' : define('N8_ROOT', '/media/work/code/N8/');
		defined('PROJECT_CONFIG') ? '' : define('PROJECT_CONFIG', N8_ROOT . 'unit/');
		defined('PROJECT_NAME') ? '' : define('PROJECT_NAME', 'test');
		defined('PROJECT_ROOT') ? '' : define('PROJECT_ROOT', dirname(dirname(__FILE__)) . '/');//项目地址
		require_once N8_ROOT . './Config.php';
		$this->conf = new N8_Config(PROJECT_CONFIG . '/' . PROJECT_NAME . '.php');
		include_once N8_ROOT . './Dblayer/Interface.php';
		include_once N8_ROOT . './Dblayer/Keyvalue.php';
		include_once N8_ROOT . './Dblayer/Memcache.php';
		$this->obj = N8_Dblayer_Memcache::getSingle();
	}

	protected function tearDown()
	{
		$this->obj->close();
		$this->obj = null;
		$this->conf = null;
	}

	/**
	 * testSetConnect 
	 * 
	 * @param mixed $dbHost 
	 * @param mixed $dbPort 
	 * @access public
	 * @return void
	 */
	public function testSetConnect()
	{
		$this->obj->setConnect(array('dbHost' => '127.0.0.1', 'dbPort' => '11211'));
		$this->assertGreaterThan(0, (int)$this->obj->getServerStatus('127.0.0.1', '11211'));
		$this->obj->close();
		$this->obj->setConnect(array('dbHost' => array('127.0.0.1', '127.0.0.1', '127.0.0.1'), 'dbPort' => array(11211, 11212, 11213)));
		$this->assertGreaterThan(0, (int)$this->obj->getServerStatus('127.0.0.1', '11211'));
		$this->assertGreaterThan(0, (int)$this->obj->getServerStatus('127.0.0.1', '11212'));
		$this->assertGreaterThan(0, (int)$this->obj->getServerStatus('127.0.0.1', '11213'));
	}

	public function test__call()
	{
		$this->assertEquals(false, $this->obj->xxx());
	}

	/**
	 * testCreate 
	 * 
	 * @access public
	 * @return void
	 */
	public function testCreateAndGetAndSetAndDel()
	{
		$this->obj->setConnect(array('dbHost' => '127.0.0.1', 'dbPort' => '11211'));
		$this->assertEquals(true, $this->obj->create(array('key' => 'a1', 'value' => 1, 'exp' => 3600, 'flag' => 1)));
		$this->assertEquals(true, $this->obj->create(array('key' => 'a2', 'value' => 2)));
		$this->assertEquals(true, $this->obj->create(array('key' => 'a3', 'value' => 3, 'exp' => 3600)));

		$this->assertEquals(1, $this->obj->get('a1'));
		$this->assertEquals(2, $this->obj->get('a2'));
		$this->assertEquals(3, $this->obj->get('a3'));

		$this->assertEquals(true, $this->obj->set(array('key' => 'a1', 'value' => 3, 'exp' => 3600, 'flag' => 1)));
		$this->assertEquals(true, $this->obj->set(array('key' => 'a2', 'value' => 4)));
		$this->assertEquals(true, $this->obj->set(array('key' => 'a3', 'value' => 2, 'exp' => 3600)));
		
		$this->assertEquals(3, $this->obj->get('a1'));
		$this->assertEquals(4, $this->obj->get('a2'));
		$this->assertEquals(2, $this->obj->get('a3'));

		$this->assertEquals(true, $this->obj->del(array('key' => 'a1', 'exp' => 360)));
		$this->assertEquals(true, $this->obj->del(array('key' => 'a2')));
		$this->assertEquals(true, $this->obj->del(array('key' => 'a3')));
		
		$this->assertEquals(false, $this->obj->get('a1'));
		$this->assertEquals(false, $this->obj->get('a2'));
		$this->assertEquals(false, $this->obj->get('a3'));
	}

	public function testIncrement()
	{
		$this->obj->setConnect(array('dbHost' => '127.0.0.1', 'dbPort' => '11211'));
		$this->assertEquals(true, $this->obj->increment(array('key' => 'a')));
		$this->assertEquals(1, $this->obj->get('a'));
		$this->assertEquals(true, $this->obj->increment(array('key' => 'a', 'value' => 3)));
		$this->assertEquals(4, $this->obj->get('a'));
	}
}
