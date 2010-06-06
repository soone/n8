<?php
/**
 * Mysql数据库操作
 *
 * @author soone(fengyue15#163.com)
 */
class N8_Dblayer_Mysql implements N8_Dblayer_Interface
{
	public $dsObj;
	public $dsLink = array();
	private function __construct(){}

	public static getSingle()
	{
		if(!is_object($this->dsObj))
			$this->dsObj = new N8_Dblayer_Mysql();

		return $this->dsObj;
	}

	public function setConnect($dsConnect = NULL)
	{
		$linkName = md5(explode('', $dsConnect));
		if(!$this->dsLink[$linkName])
	}

	public function create(){}
	public function get(){}
	public function set(){}
	public function del(){}
}
