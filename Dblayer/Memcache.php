<?php
/**
 * Mysql数据库操作
 *
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './Dblayer/Interface.php';
require_once N8_ROOT . './Dblayer/Keyvalue.php';
class N8_Dblayer_Memcache extends N8_Dblayer_Keyvalue implements N8_Dblayer_Interface
{
	/**
	 * 数据库类型
	 *
	 * @var mixed
	 */
	const DSTYPE = 'memcache';

	/**
	 * memcache主机地址 
	 * 
	 * @var array
	 * @access public
	 */
	public $dsHost = array();

	/**
	 * memcache对象 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $dsObj;

	/**
	 * memcache端口 
	 * 
	 * @var string
	 * @access public
	 */
	public $dsPort = array();

	private function __construct()
	{
		$this->dsObj = new memcache;
	}

	/**
	 * 单件返回对象 
	 * 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function getSingle()
	{
		if(!is_object(self::$dsObj))
			self::$dsObj = new N8_Dblayer_Memcache();

		return self::$dsObj;
	}

	/**
	 * 数据库连接 
	 * 
	 * @param mixed $dsConnect 
	 * @access public
	 * @return void
	 */
	public function setConnect($dsConnect = NULL)
	{
		$this->dsHost = $dsConnect['dbHost'];
		$this->dsPort = $dsConnect['dbPort'];
		if(is_array($this->dsHost))
		{
			for($i = 0, $c = count($this->dsHost); $i < $c; $i++)
				$this->dsObj->addServer($this->dsHost[$i], $this->dsPort[$i]);
		}
		else
			$this->dsObj->connect($this->dsHost, $this->dsPort);
	}

	/**
	 * 创建一条数据 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function create($option)
	{
		if(!$option['key'] || !$option['value'])
			throw new N8_Dblayer_Exception('Invalid Argument', 80000);

		return $this->dsObj->set($option['key'], $option['value'], $option['flag'], $option['exp']);
	}

	/**
	 * 取得数据 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function get($option)
	{
		if(!$option['key'])
			throw new N8_Dblayer_Exception('Invalid Argument', 80000);

		if(is_array($option['key']))
		{
			for($i = 0, $c = count($option['key']); $i < $c; $i++)
			{
				$rValue[$option['key'][$i]] =  $this->dsObj->get($option['key']);
			}
		}
		else
			$rValue = $this->dsObj->get($option['key']);

		return $rValue;
	}

	/**
	 * 更新数据 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function set($option)
	{
		return $this->create($option);
	}

	/**
	 * 删除数据 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function del($option)
	{
		if(!$option['key'])
			throw new N8_Dblayer_Exception('Invalid Argument', 80000);

		return $this->dsObj->delete($option['key'], $option['exp']);
	}

	/**
	 * 直接返回memcache对象 
	 * 
	 * @access public
	 * @return void
	 */
	public function getObj()
	{
		return $this->dsObj;
	}

	/**
	 * 清除所有缓存 
	 * 
	 * @access public
	 * @return void
	 */
	public function goFlush()
	{
		return $this->dsObj->flush();
	}

	public function increment()
	{
		return $this->dsObj->increment();
	}
}
