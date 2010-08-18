<?php
/**
 * 一般规则解析路由器程序文件
 *
 * @author soone(fengyue15#163.com)
 */
require N8_ROOT . './Router/Interface.php';
class N8_Router_CommonParse implements N8_Router_Interface
{
	/**
	 * 解析出来的控制器名称 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $c;

	/**
	 * 解析出来的动作名称 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $a;

	/**
	 * 配置对象 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $conf;

	/**
	 * url上的参数 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $get = array();

	/**
	 * 路由解析方法 
	 * 
	 * @access public
	 * @return void
	 */
	public function parse($conf)
	{
		$this->conf = $conf;
		$this->c = ucfirst(trim($_REQUEST['control']));
		$this->a = lcfirst(trim($_REQUEST['action']));
		if(!$this->c && $defControl = $this->conf->get('router->defControl'))
			$this->c = ucfirst($defControl);

		if(!$this->a && $defAction = $this->conf->get('router->defAction'))
			$this->a = lcfirst($defAction);
	}

	/**
	 * 返回控制器名词 
	 * 
	 * @access public
	 * @return void
	 */
	public function getControl()
	{
		return $this->c;
	}

	/**
	 * 返回控制器所带的动作 
	 * 
	 * @access public
	 * @return void
	 */
	public function getAction()
	{
		return $this->a;
	}

	/**
	 * 取得get参数 
	 * 
	 * @access public
	 * @return void
	 */
	public function getGet()
	{
		return $_GET;
	}

	/**
	 * 取得post参数 
	 * 
	 * @access public
	 * @return void
	 */
	public function getPost()
	{
		return $_POST;
	}

	/**
	 * 取得cookie参数 
	 * 
	 * @access public
	 * @return void
	 */
	public function getCookie()
	{
		return $_COOKIE;
	}
}
