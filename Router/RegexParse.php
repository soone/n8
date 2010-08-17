<?php
/**
 * 正则解析路由器程序文件
 *
 * @author soone(fengyue15#163.com)
 */
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
		$rUriArr = explode('/', $rUri);
		if($rUriArr[1])
			$this->c = ucfirst($rUriArr[1]);
		else
			$this->c = ucfirst($this->conf->get('router->defControl')));
		
		if($rUriArr[2] && in_array($rUriArr[2], $this->conf->get('router->' . $this->c . '->acs')))
			$this->a = lcfirst($rUriArr[2]);
		else
			$this->a = lcfirst($this->conf->get('router->defAction'));
		
		if($regRule = $this->conf->get('router->' . $this->c . '->' . $this->a))
		{
			$c = count($regRule);
			if($c > 0)
			{
				$getKeys = array_keys($regRule);
				for($i = 0; $i < $c; $i++)
				{
					if(preg_match($regRule[$getKeys[$i]], $rUri, $matchs))
						$this->get[$getKeys[$i]] = $matchs[1];
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
