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
	 */
	const dsType = 'mysql';

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

	/**
	 * 数据源字符类型 
	 * 
	 * @var mixed
	 * @access public
	 */
	public $dsCharset = 'utf8';

	public $table;

	public $sql;

	public $where;

	public $set;

	public $errorCode;

	public $errorInfo;

	private function __construct(){}

	/**
	 * 单件返回对象 
	 * 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function getSingle()
	{
		if(!is_object($this->dsObj))
			$this->dsObj = new N8_Dblayer_Mysql();

		return $this->dsObj;
	}

	/**
	 * 数据库连接 
	 * 
	 * @param mixed $dsConnect 
	 * @access public
	 * @return void
	 */
	public function setConnect($dsConnect = NULL)
	{
		$this->dsLinkName = md5(explode('', $dsConnect));
		if(!$this->dsLink[$this->dsLinkName])
		{
			$this->dsLink[$this->dsLinkName] = new PDO($this->dsType . ':dbname=' . $this->dsDb . ';host=' . $this->dsHost . ';port=' . $this->dsPort, $this->dsUser, $this->dsPass);
			$this->dsLink[$this->dsLinkName]->query('SET NAMES ' . $this->dsCharset);
		}

	}

	/**
	 * 创建一条数据 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function create($option)
	{
		//$this->sql = $this->setTable($option['table'])->setSet($option['set'])->setWhere($option['where'])->setSql();
		$this->setSql($option);

		//如果插入多条使用预处理模式
		if(sizeof($option['value']) > 1)
		{
			$sth = $this->dsLink[$this->dsLinkName]->prepare($this->sql);
			foreach($option['value'] as $v)
			{
				$vSize = sizeof($v);
				for($i = 1; $i <= $vSize; $i++)
				{
					$sth->bindParm($i, $v[$i]);
				}

				$rExec = $sth->execute();
				if($rExec === true)
				{
					$r++;
				}
				else
				{
					$this->errorCode = $sth->errorCode();
					break;
				}
			}
		}
		else
		{
			$r = $this->dsLink[$this->dsLinkName]->exec($this->sql);
			$this->errorCode = $this->dsLink[$this->dsLinkName]->errorCode();
		}

		if($this->errorCode == '00000')
			return $r;
		else
			return false;
	}

	/**
	 * 取得数据结果集 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function get($option)
	{
		//$this->sql = $this->setTable($option['table'])->setSelect($option['select'])->setWhere($option['where'])->setGroup($option['group'])->setLimit($option['limit'])->setSql();
		$this->setSql($option);

		$q = $this->dsLink[$this->dsLinkName]->query($this->sql);
		$this->errorCode = $q->errorCode();
		if(is_object($q) && $errCode == '00000')
		{
			foreach($q as $row)
			{
				$r[] = $row;
			}
		}

		if($this->errorCode == '00000')
			return $r;
		else
			return false;
	}

	/**
	 * 更新数据 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function set($option)
	{
		$this->setSql($option);

		$sth = $this->dsLink[$this->dsLinkName]->exec($this->sql);
		$this->errorCode = $this->dsLink[$this->dsLinkName]->errorCode();

		if($this->errorCode == '00000')
			return $sth;
		else
			return false;
	}

	/**
	 * 删除数据 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function del($option)
	{
		$this->setSql($option);

		$sth = $this->dsLink[$this->dsLinkName]->exec($this->sql);
		$this->errorCode = $this->dsLink[$this->dsLinkName]->errorCode();

		if($this->errorCode == '00000')
			return $sth;
		else
			return false;
	}

	/**
	 * setSql 
	 * 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function setSql($option)
	{
		
	}

	/**
	 * __destruct 
	 * 
	 * @access public
	 * @return void
	 */
	public function __destruct()
	{
		foreach($this->dsLink as $link)
		{
			unset($link);
		}
	}
}
