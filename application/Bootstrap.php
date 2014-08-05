<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{
    
    protected function _initView(){

        Zend_Layout::startMvc();
        $router = Zend_Controller_Front::getInstance()->getRouter();
        
        $route = new Zend_Controller_Router_Route('/hizlierisim/:tip',array(
            'controller' => 'hizlierisim',
            'action'     => 'index'
        ));
        
        $router->addRoute('hizlierisim', $route); 

        $route = new Zend_Controller_Router_Route('/hizlierisim/:tip/dil/:dil',array(
            'controller' => 'hizlierisim',
            'action'     => 'index'
        ));

        $router->addRoute('hizlierisimdil', $route); 

        $route = new Zend_Controller_Router_Route('/hizlierisim/kaydet',array(
            'controller' => 'hizlierisim',
            'action'     => 'kaydet'
        ));

        $router->addRoute('hizlierisimkaydet', $route); 

        $route = new Zend_Controller_Router_Route('/hizlierisim/kaydetyeni',array(
            'controller' => 'hizlierisim',
            'action'     => 'kaydetyeni'
        ));

        $router->addRoute('hizlierisimkaydetyeni', $route); 

        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('pendik');
        $view->env = APPLICATION_ENV;

        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);

        // Return it, so that it can be stored by the bootstrap
        return $view;
    }
}