<?php
/**
 * 正则解析路由器程序文件
 *
 * @author soone(fengyue15#163.com)
 */
require N8_ROOT . './Router/Interface.php';
class N8_Router_RegexParse implements N8_Router_Interface
{
	/**
	 * 解析出来的控制器名称 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $c;

	/**
	 * 解析出来的动作名称 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $a;

	/**
	 * 配置对象 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $conf;

	/**
	 * url上的参数 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $get = array();

	/**
	 * 路由解析方法 
	 * 
	 * @access public
	 * @return void
	 */
	public function parse($conf)
	{
		$this->conf = $conf;
		$rUri = $_SERVER['REQUEST_URI'];
		if($rUri == '/')
		{
			$this->c = ucfirst($this->conf->get('router->defControl'));
			$this->a = lcfirst($this->conf->get('router->defAction'));
			return;
		}

		$rUriArr = explode('/', $rUri);
		$cLen = $aLen = 0;
		$rUriArr[1] = ucfirst($rUriArr[1]);
		if($rUriArr[1] && $this->conf->get('router->' . $rUriArr[1]))
		{
			$this->c = $rUriArr[1];
			$cLen = strlen($this->c);
		}
		else
			$this->c = ucfirst($this->conf->get('router->defControl'));
		
		$acs = $this->conf->get('router->' . $this->c . '->acs');
		if($acs && $rUriArr[2] && in_array($rUriArr[2], $acs))
		{
			$this->a = lcfirst($rUriArr[2]);
			$aLen = strlen($this->a);
		}
		else
			$this->a = lcfirst($this->conf->get('router->defAction'));
		
		if($regRule = $this->conf->get('router->' . $this->c . '->' . $this->a . '->regex'))
		{
			$getPars = substr($rUri, $cLen+$aLen);
			if(preg_match($regRule, $getPars, $matchs))
			{
				$keys = $this->conf->get('router->' . $this->c . '->' . $this->a . '->keys') ;
				for($i=0,$c=count($keys); $i < $c; $i++)
				{
					$this->get[$keys[$i]] = $matchs[$i+1];
				}
			}
		}
	}

	/**
	 * 返回控制器名词 
	 * 
	 * @access public
	 * @return void
	 */
	public function getControl()
	{
		return $this->c;
	}

	/**
	 * 返回控制器所带的动作 
	 * 
	 * @access public
	 * @return void
	 */
	public function getAction()
	{
		return $this->a;
	}

	/**
	 * 取得get参数 
	 * 
	 * @access public
	 * @return void
	 */
	public function getGet()
	{
		return $this->get;
	}

	/**
	 * 取得post参数 
	 * 
	 * @access public
	 * @return void
	 */
	public function getPost()
	{
		return $_POST;
	}

	/**
	 * 取得cookie参数 
	 * 
	 * @access public
	 * @return void
	 */
	public function getCookie()
	{
		return $_COOKIE;
	}
}
