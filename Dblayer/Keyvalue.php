<?php
/**
 * n8数据层抽象
 *
 * @author soone(fengyue15#163.com)
 */
abstract class N8_Dblayer_Keyvalue
{
	/**
	 * 自增加1操作 
	 * 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract function increment();

	/**
	 * 自减1操作 
	 * 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract function decrement();

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
}
