<?php
/**
 * 一般规则解析路由器程序文件
 *
 * @author soone(fengyue15#163.com)
 */
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
		$c = ucfirst(trim($_REQUEST['control']));
		$a = lcfirst(trim($_REQUEST['action']));
		if(!$c && $defControl = $this->conf->get('router->defControl'))
			$c = ucfirst($defControl);

		if(!$a && $defAction = $this->conf->get('router->defAction'))
			$a = lcfirst($defAction);

		$this->c = self::PRO_CON_DIR . '_' . $c;
		$this->a = $a;
		//根据路由规则返回所有的请求参数，包括get, post, cookie 
		//todo put delete
		$this->r = array(
			'__N8ENV__' => array($c, $a),
		);

		$_GET ? $this->r['get'] = $_GET : '';
		$_POST ? $this->r['post'] = $_POST : '';
		$_COOKIE ? $this->r['cookie'] = $_COOKIE : '';
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
		return $this->get;
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
