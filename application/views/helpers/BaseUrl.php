<?php
class Zend_View_Helper_BaseUrl
{
	public function baseUrl()
	{
		$frontController = Zend_Controller_Front::getInstance();
		$request = $frontController->getRequest();
		return $request->getBaseUrl();				
	}
}
?>