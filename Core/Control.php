<?php
/**
 * N8控制器
 *
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './Exception.php';
class N8_Core_Control
{
	public $conf;
	public $req;
	public function __construct($conf, $r = NULL)
	{
		$this->conf = $conf;
		//权限控制ACL
		$this->checkAcl();
		//根据配置信息过滤$_GET, $_POST, $_COOKIE等参数
		$this->getRequest($r);
		//调用子类里面的初始化方法
		$this->__init();
	}

	public function __init(){}

	public function checkAcl()
	{}

	/**
	 * 处理外部请求参数$_GET,$_POST,$_COOKIE 
	 * 
	 * @param mixed $r 
	 * @access public
	 * @return void
	 */
	public function getRequest($r)
	{
		if(sizeof($r) == 1 && $r['__N8ENV__'])
		{
			$this->req = $r;
			return;
		}

		$req = new N8_Request_Request();
		$this->req = $req->filterRequest($this->conf->get($r['__N8ENV__'][0] . '->req'), $r);
	}

	/**
	 * 视图渲染调用方法
	 * 
	 * @param mixed $tpl 
	 * @access public
	 * @return void
	 */
	public function render($var = NULL)
	{
		if(!is_object($this->view))
		{
			if(!$vExt = $this->conf->get('view->extend'))
			{
				require_once N8_ROOT . './Core/View.php';
				$vExt = 'N8_Core_View';
			}

			$cView = new $vExt();
			//创建视图实例
			$this->view = $cView->createView($this->conf->get('view'));
		}

		if($var)
		{
			$var['tpl'] ? $tpl = $var['tpl'] : '';
			unset($var['tpl']);
			$var ? $this->view->assign($var) : '';
		}

		!$tpl ? $tpl = $this->req['__N8ENV__'][0] . '_' . $this->req['__N8ENV__'][1] . $this->conf->get('view->suffix') : '';
		if(isset($var['__N8RENDFETCH__']))
			return $this->view->fetch($tpl);
		else
			$this->view->display($tpl);
	}

	/**
	 * 当方法不存在的时候的处理 
	 * 
	 * @param mixed $method 
	 * @param mixed $args
	 * @access public
	 * @return void
	 */
	public function __call($method, $args)
	{
		if(method_exists($this->view, $method))
			return call_user_func_array(array($this->view, $method), $args);

		if(!RELEASE)
		{
			throw new N8_Exception('The Method ' . $method . ' is not exists', 310);
			return;
		}

		//记录日志

		//跳转到错误页面
		if(defined(PROJECT_404))
			header('Location:' . PROJECT_404);
		else
			header('Location:' . N8_404);
	}
}
