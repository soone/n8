<?php
/**
 * 显示消息脚手架
 *
 * @author soone(fengyue15#163.com)
 */
require_once N8_ROOT . './Helper/Exception.php';
class N8_Helper_Helper
{
	static function showMessage($msg = NULL, $goUrl = NULL)
	{
		$js .= '<script language="javascript" type="text/javascript">';
		$msg ? $js .= 'alert("' . $msg . '");' : '';
		$js .= $goUrl ? 'location.href="' . $goUrl . '";' : 'history.go(-1);';
		$js .= '</script>';

		echo $js;
	}
}
