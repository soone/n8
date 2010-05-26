<?php
/**
 * N8控制器
 *
 * @author soone fengyue15#163.com
 */
class N8_Core_Control
{
	public $conf;
	public $subClass;
	public $request;
	public function __construct($conf)
	{
		$this->conf = $conf;
		$cClass = get_called_class();
		$this->subClass = lcfirst(substr($cClass, strrpos($cClass, '_')+1));
		//权限控制ACL
		$this->checkAcl();
		//根据配置信息过滤$_GET, $_POST, $_COOKIE等参数
		$this->getRequest();
		//调用子类里面的初始化方法
		$this->__init();
	}

	public function __init(){}

	public function checkAcl()
	{}

	public function getRequest()
	{
		$req = new N8_Request_Request();
		$this->request['get'] = $req->filterGet($this->conf->get($this->subClass . '->get'));
	}
}
