<?php
/**
 * n8数据过滤
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './Request/Exception.php';
class N8_Request_Request 
{
	/**
	 * 所有请求的环境参数和变量 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $rVal = NULL;

	protected $actionRule;

	public function __construct($r = NULL)
	{
		if($r)
			$this->rVal = $r;
	}

	/**
	 * 设置action的全局过滤规则
	 * 
	 * @param mixed $actionRule 
	 * @access public
	 * @return void
	 */
	public function setActionRule($actionRule = NULL)
	{
		if($actionRule)
			$this->actionRule = (array)$actionRule;
	}

	/**
	 * 执行过滤操作 
	 * 
	 * @access public
	 * @return array
	 */
	public function filterRequest()
	{
		if(!$this->rVal) return false;

	}
}
