<?php
/**
 * Mysql数据库操作
 *
 * @author soone(fengyue15#163.com)
 */
class N8_Dblayer_Mysql implements N8_Dblayer_Interface
{
	/**
	 * 单件对象 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $dsObj;

	/**
	 * 数据库连接标示数组 
	 * 
	 * @var array
	 * @access public
	 */
	public $dsLink = array();

	/**
	 * 当前连接名字 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $dsLinkName;

	/**
	 * 数据库类型
	 *
	 * @var mixed
	 * @access public
	 */
	public const dsType = 'mysql';

	/**
	 * 数据库主机地址 
	 * 
	 * @var string
	 * @access public
	 */
	public $dsHost = 'localhost';

	/**
	 * 连接的数据库名称 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $dsDb;

	/**
	 * 数据库端口 
	 * 
	 * @var string
	 * @access public
	 */
	public $dsPort = '3389';

	/**
	 * 数据库用户名密码 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $dsUser;
	public $dsPass;

	public $dsCharset;

	private function __construct(){}

	public static getSingle()
	{
		if(!is_object($this->dsObj))
			$this->dsObj = new N8_Dblayer_Mysql();

		return $this->dsObj;
	}

	public function setConnect($dsConnect = NULL)
	{
		$this->dsLinkName = md5(explode('', $dsConnect));
		if(!$this->dsLink[$linkName])
			$this->dsLink[$linkName] = new PDO($this->dsType . ':dbname=' . $this->dsDb . ';host=' . $this->dsHost . ';port=' . $this->dsPort, $this->dsUser, $this->dsPass);

	}

	public function create(){}
	public function get(){}
	public function set(){}
	public function del(){}
}
