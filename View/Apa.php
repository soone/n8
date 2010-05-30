<?php
/**
 * 适配器接口
 *
 * @author soone(fengyue15#163.com)
 */
interface N8_View_Apa
{
	/**
	 * 模板配置信息
	 * 
	 * @param mixed $conf 
	 * @access public
	 * @return void
	 */
	public function config($conf);

	/**
	 * 赋值方法
	 * 
	 * @param mixed $var 
	 * @access public
	 * @return void
	 */
	public function assign($var);

	/**
	 * 返回模板内容 
	 * 
	 * @param mixed $var 
	 * @access public
	 * @return void
	 */
	public function fetch($var);

	/**
	 * 显示模板 
	 * 
	 * @param mixed $var 
	 * @access public
	 * @return void
	 */
	public function display($var);
}
