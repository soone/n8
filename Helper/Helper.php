<?php
/**
 * 显示消息脚手架
 *
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './Helper/Exception.php';
class N8_Helper_Helper
{
	/**
	 * 消息显示 
	 * 
	 * @param mixed $msg 
	 * @param mixed $goUrl 
	 * @static
	 * @access public
	 * @return void
	 */
	static function showMessage($msg = NULL, $goUrl = NULL)
	{
		$js .= '<script language="javascript" type="text/javascript">';
		$msg ? $js .= 'alert("' . $msg . '");' : '';
		$js .= $goUrl ? 'location.href="' . $goUrl . '";' : 'history.go(-1);';
		$js .= '</script>';

		echo $js;
	}

	/**
	 * 返回页面信息 
	 * 
	 * @param mixed $options 
	 * @static
	 * @access public
	 * @return void
	 */
	static function setPage($options)
	{
		if($options['allNums'] <= $options['perNum']) return;
		$page['allPages'] = ceil($options['allNums']/$options['perNum']);
		switch($options['type'])
		{
			case 0:
			default:
				$offset = 3;
				$curBar = $offset*2+1;
				if($page['allPages'] <= $curBar)
				{
					$page['max'] = $page['allPages'];
					$page['min'] = 1;
				}
				else
				{
					if($options['curPage']-$offset <= 1)
					{
						$page['max'] = $curBar;
						$page['min'] = 1;
					}
					elseif($options['curPage']+$offset > $page['allPages'])
					{
						$page['max'] = $page['allPages'];
						$page['min'] = $page['allPages']-$curBar+1;
					}
					else
					{
						$page['max'] = $options['curPage']+$offset;
						$page['min'] = $options['curPage']-$offset;
					}
				}
				break;
		}

		$page['allNums'] = $options['allNums'];
		$page['curPage'] = $options['curPage'];

		return $page;
	}
}
