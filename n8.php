<?php
/**
 * n8框架初始化程序文件
 *
 * @author soone<fengyue15 at 163.com>
 */
define('VERSION', 'v0.0.1');
define('N8ROOT', dirname(__FILE__));
final class N8
{
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
        if(file_exists($fullPath = PROJECT_DIR . '/' . $classPath) || file_exists($fullPath = LIBRARY . '/' . $classPath))
        {
        	include_once($fullPath);
        }
        else if($splFuncs == 1)
        {
        	include_once LIBRARY . '/LoadException.php';
        	eval("class $className{}");
        	throw new LoadException('请求的类：' . $className . '不存在', 404);
        }
                                                                                                                           
        if(!class_exists($className) && $splFuncs == 1)
        {
        	include_once LIBRARY . '/LoadException.php';
        	eval("class $className{}");
        	throw new LoadException('请求的类：' . $className . '不存在', 404);
        }














	}
}
