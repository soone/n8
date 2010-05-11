<?php
/**
 * n8框架初始化程序文件
 *
 * @author soone<fengyue15 at 163.com>
 */
define('VERSION', 'v0.0.1');
final class N8
{
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
        	require_once  'N8/Exception.php';
        	eval("class $cName{}");
        	throw new N8_Exception('The class ' . $cName . ' not exists', 280);
        }
	}
}
//set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__)));
//$a = new N8;
//new fas;
