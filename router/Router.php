<?php
/**
 * n8框架路由器程序文件
 *
 * @author soone<fengyue15 at 163.com>
 */
require_once 'N8/RouterException.php';
class N8_Router
{
	/**
	 * 路由解析取得的动作 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $action;

	/**
	 * 路由解析取得的控制器 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $control;

	public $prefix;

	public function __construct(){}

	/**
	 * 路由解析方法 
	 * 
	 * @access public
	 * @return void
	 */
	public function parse()
	{
		
	}

	public function setPrefix()
	{}

	public function getPrefix()
	{}
}
