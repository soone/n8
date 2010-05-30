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
		if(!in_array($conf['view'], array('Smarty', 'Discuz')))
			throw new N8_View_Exception('Invalid Template Engine', 214);

		include_once N8_ROOT . './View/' . $conf['view'] . 'Apa.php';
		$v = $conf['view'] . 'Apa';
		$this->view = new $v($conf);
		return $this->view;
	}
}
