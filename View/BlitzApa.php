<?php
/**
 * Blitz模板引擎适配器 
 *
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './View/Exception.php';
require_once N8_ROOT . './View/Apa.php';
class N8_View_BlitzApa implements N8_View_Apa
{
	public function __construct(){}

	public function config($conf)
	{
		$this->view = new Blitz();
		foreach($conf as $k => $v)
		{
			$this->view->$k = $v;
		}
	}

	public function assign($var)
	{
		$this->view->assign($var);
	}

	public function fetch($var)
	{
		return $this->view->fetch($var);
	}

	public function display($var)
	{
		$this->view->display($var);
	}
}
