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
	 * @static
	 * @var mixed
	 * @access public
	 */
	static $dsObj;

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
	const DSTYPE = 'mysql';

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

	public $sqlWhere;

	public $sqlKey;

	public $sqlValue;

	public $sqlSet;

	public $sqlLimit;

	public $sqlOrder;

	public $sqlGroup;

	public $errorCode;

	public $errorInfo;

	public $lastInsertId;

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
		if(!is_object(self::$dsObj))
			self::$dsObj = new N8_Dblayer_Mysql();

		return self::$dsObj;
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
		$this->dsLinkName = md5(implode('', (array)$dsConnect));
		$this->dsDb = $dsConnect['dbName'];
		$this->dsHost = $dsConnect['dbHost'];
		$this->dsPort = $dsConnect['dbPort'];
		$this->dsUser = $dsConnect['dbUser'];
		$this->dsPass = $dsConnect['dbPass'];

		if(!$this->dsLink[$this->dsLinkName])
		{
			$this->dsLink[$this->dsLinkName] = new PDO(self::DSTYPE . ':dbname=' . $this->dsDb . ';host=' . $this->dsHost . ';port=' . $this->dsPort, $this->dsUser, $this->dsPass);
			$this->dsLink[$this->dsLinkName]->exec('SET NAMES ' . $this->dsCharset);
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
		if(!$option['key'] || !$option['value'])
			throw new N8_Dblayer_Exception('Invalid Argument', 40000);

		$this->setSql(1, $option);

		$r = $this->dsLink[$this->dsLinkName]->exec($this->sql);
		$this->errorCode = $this->dsLink[$this->dsLinkName]->errorCode();
		$this->errorInfo = $this->dsLink[$this->dsLinkName]->errorInfo();

		if($this->errorCode == '00000')
		{
			$this->lastInsertId = $this->dsLink[$this->dsLinkName]->lastInsertId();
			return $r;
		}
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
		if(!$option['key'])
			throw new N8_Dblayer_Exception('Invalid Argument', 40000);

		$this->setSql(2, $option);

		$q = $this->dsLink[$this->dsLinkName]->query($this->sql);
		if(is_object($q))
		{
			$q->setFetchMode(PDO::FETCH_NUM);
			$this->errorCode = $q->errorCode();
			$this->errorInfo = $q->errorInfo();
			$r = $q->fetchAll();
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
		if(!$option['key'] || !$option['value'])
			throw new N8_Dblayer_Exception('Invalid Argument', 40000);

		$this->setSql(3, $option);

		$sth = $this->dsLink[$this->dsLinkName]->exec($this->sql);
		$this->errorCode = $this->dsLink[$this->dsLinkName]->errorCode();
		$this->errorInfo = $this->dsLink[$this->dsLinkName]->errorInfo();

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
		$this->setSql(4, $option);

		$sth = $this->dsLink[$this->dsLinkName]->exec($this->sql);
		$this->errorCode = $this->dsLink[$this->dsLinkName]->errorCode();
		$this->errorInfo = $this->dsLink[$this->dsLinkName]->errorInfo();

		if($this->errorCode == '00000')
			return $sth;
		else
			return false;
	}

	/**
	 * 取得最后插入的id 
	 * 
	 * @access public
	 * @return void
	 */
	public function getLastInsertId()
	{
		return $this->lastInsertId;
	}

	/**
	 *  生成sql
	 * 
	 * @param mixed $type 
	 * @param mixed $option 
	 * @access public
	 * @return void
	 */
	public function setSql($type, $option)
	{
		unset($this->sql);
		if($option['table'])
			$this->table = $option['table'];

		switch($type)
		{
			case 1://create
				if($option['replace'] == 1)
					$operate = 'REPLACE';
				else
					$operate = 'INSERT';
				$this->setKey($option['key']);
				$this->setValue($option['value']);
				$this->sql = $operate . ' INTO ' . $this->table . '(' . $this->sqlKey . ')VALUES' . $this->sqlValue;
				break;

			case 2://get
				$this->setKey($option['key']);
				$this->setWhere($option['where']);
				$this->setLimit($option['limit']);
				$this->setOrder($option['order']);
				$this->sql = 'SELECT ' . $this->sqlKey . ' FROM ' . $this->table . $this->sqlWhere . $this->sqlOrder . $this->sqlLimit;
				break;

			case 3://set
				$this->setSet($option['key'], $option['value']);
				$this->setWhere($option['where']);
				$this->sql = 'UPDATE ' . $this->table . $this->sqlSet . $this->sqlWhere;
				break;

			case 4://del
				$this->setWhere($option['where']);
				$this->sql = 'DELETE FROM ' . $this->table . $this->sqlWhere;
				break;
		}

		$this->builtInStr();
		return $this->sql;
	}

	/**
	 * 设置update时set格式 
	 * 
	 * @param mixed $key 
	 * @param mixed $value 
	 * @access public
	 * @return void
	 */
	public function setSet($key, $value)
	{
		unset($this->sqlSet);
		$kNums = sizeof($key);
		$set = '';
		for($i = 0; $i < $kNums; $i++)
		{
			$set .= $spe . $key[$i] . '=\'' . $value[$i] . '\'';
			$spe = ',';
		}

		$this->sqlSet = ' SET ' . $set;

		return $this->sqlSet;
	}

	/**
	 * 设置key格式 
	 * 
	 * @param mixed $key 
	 * 				$key = array('id', 'uid', 'gamename');
	 * @access public
	 * @return string
	 */
	public function setKey($key)
	{
		unset($this->sqlKey);
		$this->sqlKey = implode(',', $key);
		return $this->sqlKey;
	}

	/**
	 * 设置value格式 
	 * 
	 * @param mixed $value 
	 *              $value = array('1,2,test,xxx,,tex', 'dt,iu,,fj,234')
	 * @access public
	 * @return string
	 */
	public function setValue($value)
	{
		unset($this->sqlValue);
		foreach($value as $v)
		{
			$this->sqlValue .= $spe . '(\'' . implode('\',\'', explode(',', $v)) . '\')';
			$spe = ',';
		}

		return $this->sqlValue;
	}

	/**
	 * setWhere 
	 * 
	 * @param mixed $where 
	 *				$where = array('and' => 
	 * 									array('id' => 1, 'gameid' => array('a', 'b'), 'status' => '%test', 'num' => 1),
	 *								'or' =>
	 * 									array('id' => 1, 'gameid' => array('a', 'b'), 'status' => '%test'),
	 *								'oper' => array('num' => '>=', 'status' => 'like')
	 *							   ); 
	 * @access public
	 * @return string
	 */
	public function setWhere($where)
	{
		unset($this->sqlWhere);
		$wh = '';
		$operKey = array();
		if($where['oper'])
			$operKey = array_keys($where['oper']);

		if($where['and'])
		{
			foreach($where['and'] as $k => $w)
			{
				if(is_array($w))
					$wh .= $and . $k . ' IN(\'' . implode('","', $w) . '\')';
				else
				{
					$s = '=';
					if(in_array($k, $operKey))
						$s =  ' ' .$where['oper'][$k] . ' ';

					$wh .= $and . $k . $s . '\'' . $w . '\'';
				}

				$and = ' AND ';
			}
		}

		if($where['or'])
		{
			if($wh) $or = ' OR ';
			foreach($where['or'] as $k => $w)
			{
				if(is_array($w))
					$wh .= $or . $k . ' IN(\'' . implode('\',', $w) . '\')';
				else
				{
					$s = '=';
					if(in_array($k, $operKey))
						$s =  ' ' .$where['oper'][$k] . ' ';

					$wh .= $or . $k . $s . '\'' . $w . '\'';
				}

				$or = ' OR ';
			}
		}

		if($wh)
			$this->sqlWhere = ' WHERE ' . $wh;

		return $this->sqlWhere;
	}

	/**
	 * 设置limit格式 
	 * 
	 * @param mixed $start 
	 * @param mixed $perNums 
	 * @access public
	 * @return string
	 */
	public function setLimit($limit)
	{
		unset($this->sqlLimit);
		if(!$limit) return;

		$this->sqlLimit = ' LIMIT ' . intval($limit[0]) . ',' . intval($limit[1]);
		return $this->sqlLimit;
	}

	/**
	 * 设置group格式
	 * 
	 * @param mixed $group 
	 * @access public
	 * @return void
	 */
	public function setGroup($group)
	{
		unset($this->sqlGroup);
		if(!$group) return;
		
		$this->sqlGroup = ' GROUP BY ' . $group['by'];
	}

	/**
	 * 返回当前sql语句 
	 * 
	 * @access public
	 * @return void
	 */
	public function getSql()
	{
		return $this->sql;
	}

	/**
	 * 返回当前错误代码 
	 * 
	 * @access public
	 * @return void
	 */
	public function getErrno()
	{
		return $this->errorCode;
	}

	/**
	 * 返回当前错误信息 
	 * 
	 * @access public
	 * @return void
	 */
	public function getError()
	{
		return $this->errorInfo;
	}

	/**
	 * 设置order格式 
	 * 
	 * @param mixed $order 
	 * @access public
	 * @return void
	 */
	public function setOrder($order)
	{
		$odby = '';
		if($order['asc'])
		{
			foreach($order['asc'] as $a)
			{
				$odby .= $asc . $a . ' ASC';
				$asc = ',';
			}
		}

		if($odby) $desc = ',';

		if($order['desc'])
		{
			foreach($order['desc'] as $d)
			{
				$odby .= $desc . $d . ' DESC';
				$desc = ',';
			}
		}

		if($odby)
			$this->sqlOrder = ' ORDER BY ' . $odby;
	}

	/**
	 * 解析sql里面带{{}}的字符 
	 * 
	 * @param mixed $str 
	 * @access protected
	 * @return void
	 */
	protected function builtInStr()
	{
		$part = '/(\'\{\{(.*?)\}\}\')/i';
		if(preg_match_all($part, $this->sql, $m))
			$this->sql = str_replace($m[1], $m[2], $this->sql);

		return $this->sql;
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
