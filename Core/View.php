<?php
/**
 * N8视图层 
 *
 * @author soone(fengyue#163.com)
 */
require_once N8_ROOT . './View/Exception.php';
class N8_Core_View
{
	/**
	 * 视图产品对象 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $view;

	public function __construct(){}

	public function createView($conf)
	{
		if(!in_array($conf['type'], array('Smarty', 'Discuz', 'Blitz')))
			throw new N8_View_Exception('Invalid Template Engine', 214);

		include_once N8_ROOT . './View/' . $conf['type'] . 'Apa.php';
		$v = 'N8_View_' . $conf['type'] . 'Apa';
		$this->view = new $v();
		$this->view->config($conf['conf']);
		return $this->view;
	}
}
