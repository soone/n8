<?php
/**
 * n8初始化程序文件
 *
 * @author soone(fengyue15#163.com)
 */
define('VERSION', 'v0.0.1');
define('N8_ROOT', dirname(__FILE__) . '/');
require_once  N8_ROOT . './Exception.php';

final class N8
{
	public $conf = '';

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
        if(file_exists($fullPath = PROJECT_ROOT . $classPath) || file_exists($fullPath = N8_ROOT . substr($classPath, 3)))
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
			define('PROJECT_CONFIG', PROJECT_ROOT . './Config');
		else
			define('PROJECT_CONFIG', PROJECT_ROOT . './Cache/Config');

		try
		{
			require_once N8_ROOT . './Config.php';
			$this->conf = new N8_Config();
		}
		catch(N8_Exception $e)
		{
			$e->n8catch();
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
			$router = new N8_Router_Router($this->conf);
			$router->parse();

			require_once N8_ROOT . './Core/Control.php';
			require_once N8_ROOT . './Core/Model.php';
			$control = $router->getControl();
			$action = $router->getAction();
			$c = new $control($this->conf, $router->getRequest());
			$c->$action();
		}
		catch(N8_Exception $e)
		{
			$e->n8catch();
		}
	}
}
//set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__)));
