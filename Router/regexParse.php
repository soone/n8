<?php
/**
 * 正则解析路由器程序文件
 *
 * @author soone(fengyue15 at 163.com)
 */
class N8_RegexParse extends N8_Router
{
	public function __construct(){}

	/**
	 * 路由解析方法 
	 * 
	 * @access public
	 * @return void
	 */
	public function parse()
	{
		
	}

	/**
	 * 设置前缀 
	 * 
	 * @param mixed $pre 
	 * @access public
	 * @return void
	 */
	public function setPrefix($pre = NULL)
	{
		$this->prefix = $pre;
		return $this;
	}

	/**
	 * 取得路由的前缀 
	 * 
	 * @access public
	 * @return void
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

	public function regexParse()
	{
		
	}
}
