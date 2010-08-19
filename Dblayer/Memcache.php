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
	CONST INVALID_VAR_MES = 'Invalid Argument';
	CONST INVALID_VAR_CODE = '80000';

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
	protected $dsObj;

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
		if(!is_object(self::$obj))
			self::$obj = new N8_Dblayer_Memcache();

		return self::$obj;
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
		if(!isset($option['key']) || !isset($option['value']) || !$option['key'] || !$option['value'])
			throw new N8_Dblayer_Exception(self::INVALID_VAR_MES, self::INVALID_VAR_CODE);

		return $this->dsObj->set($option['key'], $option['value'], 0, (isset($option['exp']) ? (int)$option['exp'] : 0));
	}

	/**
	 * 取得数据 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function get($key)
	{
		if(!$key)
			throw new N8_Dblayer_Exception(INVALID_VAR_MES, INVALID_VAR_CODE);

		return $rValue = $this->dsObj->get($key);
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
		if(!isset($option['key']) || !$option['key'])
			throw new N8_Dblayer_Exception(INVALID_VAR_MES, INVALID_VAR_CODE);

		return $this->dsObj->delete($option['key'], (isset($option['exp']) ? (int)$option['exp'] : 0));
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

	/**
	 * increment 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function increment($option)
	{
		if(!$option['key'] || !isset($option['key']))
			throw new N8_Dblayer_Exception(INVALID_VAR_MES, INVALID_VAR_CODE);

		if(!$this->get($option['key']))
			$this->set(array('key' => $option['key'], 0));

		return $this->dsObj->increment($option['key'], ( isset($option['value']) && $option['value'] ? $option['value'] : 1));
	}

	/**
	 * decrement 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function decrement($option)
	{
		if(!$option['key'] || !isset($option['key']))
			throw new N8_Dblayer_Exception(INVALID_VAR_MES, INVALID_VAR_CODE);

		return $this->dsObj->decrement($option['key'], (isset($option['value']) && $option['value'] ? $option['value'] : 1));
	}
}
