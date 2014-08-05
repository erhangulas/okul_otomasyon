<?php
class Zend_View_Helper_Tirnak
{
	public function tirnak($data)
	{	
		return str_replace('"',"'", $data);
	}
}
?>