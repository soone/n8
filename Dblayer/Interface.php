<?php
/**
 * n8数据层接口
 *
 * @author soone(fengyue15#163.com)
 */
interface N8_Dblayer_Interface
{
	public function setConnect($dsConnect = NULL);
	public function create($option);
	public function get($option);
	public function set($option);
	public function del($option);
}
