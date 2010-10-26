<?php
/**
 * N8数据层
 *
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './Dblayer/Exception.php';
class N8_Dblayer_Dblayer
{
	/**
	 * 预定义的数据源类型 
	 * 
	 * @var array
	 * @access protected
	 */
	protected $dsType = array('Memcache', 'Mysql');

	/**
	 * 当前数据源标志 
	 * 
	 * @var string
	 * @access protected
	 */
	protected $dsFlag = '';

	/**
	 * 数据源对象 
	 * 
	 * @var array
	 * @access protected
	 */
	protected static $ds = array();

	public function __construct(){}

	/**
	 * 数据源对象设置 
	 * 
	 * @param mixed $dsType 
	 * @param mixed $dsConnect 
	 * @access public
	 * @return void
	 */
	public function setDs($dsType, $dsConnect = NULL)
	{
		$this->dsFlag = md5($dsType . implode('', (array)$dsConnect));
		if(!is_object(self::$ds[$this->dsFlag]))
			$this->factory($dsType, $dsConnect);
		
		return self::$ds[$this->dsFlag];
		//return $this;
	}

	/**
	 * 创建数据源对象 
	 * 
	 * @param mixed $dsType 
	 * @param mixed $dsConnect 
	 * @access public
	 * @return void
	 */
	public function factory($dsType, $dsConnect = NULL)
	{
		if(!in_array($dsType, $this->dsType))
			throw new N8_Dblayer_Exception('N8 can not support this ds type', 4404);

		include_once N8_ROOT . './Dblayer/' . $dsType . '.php';
		$dsName = 'N8_Dblayer_' . $dsType;
		//self::$ds[$this->dsFlag] = $dsName::getSingle();
		self::$ds[$this->dsFlag] = N8_Dblayer_Mysql::getSingle();
		$dsConnect && !self::$ds['link'] ? self::$ds[$this->dsFlag]->setConnect($dsConnect) : '';
		return $this;
	}
}
