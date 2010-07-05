<?php
/**
 * n8路由器
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './Router/Exception.php';
class N8_Router_Router 
{
	/**
	 * 配置实例 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $conf;

	/**
	 * 路由解析出来的控制器 
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $c;

	/**
	 * 路由解析出来的动作
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $a;

	/**
	 * 路由解析出来的所有请求参数 
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $r;

	const PRO_CON_DIR = 'Control';

	/**
	 * 路由解析模式 
	 * 
	 * @var float
	 * 1-为传统模式 2-为正则表达式模式 3-为phpinfo模式，如：/example.com/index.php/user/getinfo/xxxxxxx
	 * @access protected
	 */
	protected $routerType = 1;

	public function __construct($conf)
	{
		$this->conf = $conf;
	}

	/**
	 * 根据配置解析路由器 
	 * 
	 * @access public
	 * @return void
	 */
	public function parse()
	{
		$this->routerType = $this->conf->get('router->type');
		switch($this->routerType)
		{
			case 1:
			default:
				$this->commonParse();
				break;

			case 2:
				$this->regexParse();
				break;

			case 3:
				$this->pathinfoParse();
				break;
		}
	}

	/**
	 * 传统路由解析
	 * 
	 * @access public
	 * @return void
	 */
	public function commonParse()
	{
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
	 * 返回control 
	 * 
	 * @access public
	 * @return void
	 */
	public function getControl()
	{
		return $this->c;
	}

	/**
	 * 返回action 
	 * 
	 * @access public
	 * @return void
	 */
	public function getAction()
	{
		return $this->a;
	}

	/**
	 * 返回request 
	 * 
	 * @access public
	 * @return void
	 */
	public function getRequest()
	{
		return $this->r;
	}
}
