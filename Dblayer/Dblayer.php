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
	 * @param mixed $dstype 
	 * @param mixed $dsoption 
	 * @access public
	 * @return object
	 */
	public function setDs($dsType, $dsOption = NULL)
	{
		$this->dsFlag = md5($dsType . implode('', (array)$dsOption));
		if(!is_object($this->ds[$this->dsFlag]))
			$this->factory($dsType, $dsOption);
		
		return $this;
	}

	/**
	 * 创建数据源对象 
	 * 
	 * @param mixed $dsType 
	 * @param mixed $dsOption 
	 * @access public
	 * @return void
	 */
	public function factory($dsType, $dsOption = NULL)
	{
		if(!in_array($dsType, $this->dsType))
			throw new N8_Dblayer_Exception('N8 can not support this ds type', 4404);

		include_once N8_ROOT . './Dblayer/' . $dsType . '.php';
		$dsName = 'N8_Dblayer_' . $dsType;
		$this->ds[$this->dsFlag] = new $dsName();
		$dsOption ? $this->setOption($dsOption) : '';
	}

	public function setOption($dsOption = NULL)
	{
		
	}
}
