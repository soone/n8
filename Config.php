<?php
/**
 * 配置文件处理类
 *
 * @author soone(fengyue15#163.com)
 */
class N8_Config
{
	public $pConf = '';
	public $pConfVariable = array();

	/**
	 * 配置信息取得的方法
	 * 
	 * @var float 1-为直接数组取得， 2-为内存取得
	 * @access public
	 */
	public $confType = 1;

	/**
	 * __construct 
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct($config)
	{
		if(file_exists($config))
		{
			require $config;
			$this->pConfVariable = $pConfig;
		}
		else
			throw new N8_Exception('The config file of project is not exists', 3404);
	}

	/**
	 * 取得配置信息 
	 * 
	 * @param mixed $getName 
	 * @access public
	 * @return void
	 */
	public function get($getName)
	{
		if($a = strrpos($getName, '->'))
		{
			$gNames = explode('->', $getName);
			$rValue = $this->pConfVariable[$gNames[0]];
			$gCount = count($gNames);
			for($i = 1; $i < $gCount; $i++)
			{
				if(!array_key_exists($gNames[$i], (array)$rValue))
				{
					$rValue = 0;
					break;
				}

				$rValue = $rValue[$gNames[$i]];
			}
		}
		else
		{
			array_key_exists($getName, $this->pConfVariable) ? $rValue = $this->pConfVariable[$getName] : '';
		}

		return $rValue;
	}
}
