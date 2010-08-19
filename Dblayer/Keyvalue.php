<?php
/**
 * n8数据层抽象
 *
 * @author soone(fengyue15#163.com)
 */
abstract class N8_Dblayer_Keyvalue
{
	static $obj;

	/**
	 * 自增加1操作 
	 * 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract function increment($option);

	/**
	 * 自减1操作 
	 * 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract function decrement($option);

	/**
	 * 清除缓存数据 
	 * 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract function goFlush();
	
	/**
	 * 直接返回缓存对象 
	 * 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract function getObj();

	/**
	 * 返回当前错误代码 
	 * 
	 * @access public
	 * @return void
	 */
	public function getErrno(){}

	/**
	 * 返回当前错误信息 
	 * 
	 * @access public
	 * @return void
	 */
	public function getError(){}

	/**
	 * __call 
	 * 
	 * @param mixed $method 
	 * @param mixed $val 
	 * @access protected
	 * @return void
	 */
	public function __call($method, $val)
	{
		if(method_exists($this->dsObj, $method))
			return call_user_func_array(array($this->dsObj, $method), (array)$val);
		else
			return false;
	}
}
