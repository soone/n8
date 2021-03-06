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
		header('Content-Type:text/html; charset=UTF-8');
		$js .= '<script language="javascript" type="text/javascript">';
		$msg ? $js .= 'alert("' . $msg . '");' : '';
		if(!$goUrl) $goUrl = $_SERVER['HTTP_REFERER'];
		$js .= 'location.href="' . $goUrl . '";';
		$js .= '</script>';

		echo $js;
		exit;
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
		$page['prevPage'] = $page['curPage'] > 1 ? $page['curPage'] - 1 : 1;
		$page['nextPage'] = $page['curPage'] < $page['allPages'] ? $page['curPage'] + 1 : $page['allPages'];

		return $page;
	}
}
