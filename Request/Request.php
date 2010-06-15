<?php
/**
 * n8数据过滤
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './Request/Exception.php';
class N8_Request_Request 
{
	public function __construct(){}

	public function filterRequest($fRule, $fArgs)
	{
		if(!$fRule)
		{
			
		}

		return $fArgs;
	}
}
