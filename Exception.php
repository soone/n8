<?php
/**
 * n8框架中的异常文件
 *
 * @author soone fengyue15#163.com
 */

class N8_Exception extends Exception
{
	/**
	 * n8内置的异常捕捉方法 
	 * 
	 * @access public
	 * @return void
	 */
	public function n8catch($line, $file)
	{
		$msg[] = 'Error File:' . $file;
		$msg[] = 'Error Line:' . $line;
		$msg[] = 'Error Message:' . $this->getMessage();
		$msg[] = 'Error Code:' . $this->getCode();
		var_export($msg);
		exit;
	}
}
