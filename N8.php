<?php
/**
 * n8框架初始化程序文件
 *
 * @author soone fengyue15#163.com
 */
define('VERSION', 'v0.0.1');
define('N8_ROOT', dirname(__FILE__) . '/');
require_once  N8_ROOT . './Exception.php';

final class N8
{
	public $config = '';

	public function __construct()
	{
		spl_autoload_register(array('N8', '__autoload'));
	}
	/**
	 * __autoload 
	 * 
	 * @static
	 * @access public
	 * @return void
	 */
	public function __autoload($cName)
	{
		$splFuncs = count(spl_autoload_functions());
        $classPath = str_replace('_', '/', $cName . '.php');
        if(file_exists($fullPath = PROJECT_ROOT . $classPath) || file_exists($fullPath = $classPath))
        {
        	require_once $fullPath;
        }
        elseif($splFuncs == 1)
        {
        	eval("class $cName{}");
        	throw new N8_Exception('The class ' . $cName . ' not exists', 280);
        }
	}

	/**
	 * n8初始化以及项目的初始化 
	 * 
	 * @access public
	 * @return void
	 */
	public function init()
	{
		if(!RELEASE)
			define('PROJECT_CONFIG', PROJECT_ROOT . './config');
		else
			define('PROJECT_CONFIG', PROJECT_ROOT . './cache');

		try
		{
			require_once N8_ROOT . './config.php';
			$this->config = new N8_Config();
		}
		catch(N8_Exception $e)
		{
			$e->n8catch(__LINE__, __FILE__);
		}

		return $this;
	}

	/**
	 * N8引擎启动 
	 * 
	 * @access public
	 * @return void
	 */
	public function run()
	{
		try
		{
			//路由解析
			require_once N8_ROOT . './Router/Router.php';
			$router = new N8_Router_Router($this->config);
			$router->parse();
			$control = $router->getControl();
			$action = $router->getAction();
			$c = new $control();
			$c->$action();
		}
		catch(N8_Exception $e)
		{
			$e->n8catch(__LINE__, __FILE__);
		}
	}
}
//set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__)));
