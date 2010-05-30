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
	public function n8catch()
	{
		$msg[] = 'Error Line:' . $this->line;
		$msg[] = 'Error Message:' . $this->message;
		$msg[] = 'Error Code:' . $this->code;
		$msg[] = 'Trace:' . $this->getTraceAsString();
		var_export($msg);
		exit;
	}
}
