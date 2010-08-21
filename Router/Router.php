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
				$routerType = 'N8_Router_CommonParse';
				require N8_ROOT . './Router/CommonParse.php';
				break;

			case 2:
				$routerType = 'N8_Router_RegexParse';
				require N8_ROOT . './Router/RegexParse.php';
				break;

			case 3:
				$routerType = 'N8_Router_PathinfoParse';
				require N8_ROOT . './Router/PathinfoParse.php';
				break;
		}

		$parse = new $routerType();
		$parse->parse($this->conf);
		$c = $parse->getControl();
		$this->c = self::PRO_CON_DIR . '_' . $c;
		$this->a = $parse->getAction();
		$this->r = array('__N8ENV__' => array($c, $this->a));
		$this->r['get'] = $parse->getGet();
		$this->r['post'] = $parse->getPost();
		$this->r['cookie'] = $parse->getCookie();
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
