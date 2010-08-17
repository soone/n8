<?php
/**
 *  路由器接口
 *
 * @author soone(fengyue#163.com)
 *
 */
interface N8_Router_Interface
{
	/**
	 * 返回控制器名称 
	 * 
	 * @access public
	 * @return void
	 */
	public function getControl();

	/**
	 * 返回动作名称 
	 * 
	 * @access public
	 * @return void
	 */
	public function getAction();

	/**
	 * 开始路由解析 
	 * 
	 * @access public
	 * @return void
	 */
	public function parse($conf);

	/**
	 * 取得get参数
	 * 
	 * @access public
	 * @return void
	 */
	public function getGet();

	/**
	 * 取得post参数 
	 * 
	 * @access public
	 * @return void
	 */
	public function getPost();

	/**
	 * 取得cookie参数
	 * 
	 * @access public
	 * @return void
	 */
	public function getCookie();
}
