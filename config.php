<?php
/**
 * 配置文件处理类
 *
 * @author soone fengyue15#163.com
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
	public function __construct()
	{
		if(RELEASE)
		{
			if(!is_file(PROJECT_CONFIG . '/' . PROJECT_NAME . '_mini.php'))
			{
				$cUrl = PROJECT_CONFIG . '/' . PROJECT_NAME . '.php';
				if(is_file($cUrl))
				{
					require_once $cUrl;
					$this->pConfVariable = $pConfig;
				}
				else
					throw new N8_Exception('The config file of project is not exists', 3404);
			}
			else
			{
				//todo 使用缓存读取
			}
		}
		else
		{
			//使用yaml直接读取
		}
	}
}

