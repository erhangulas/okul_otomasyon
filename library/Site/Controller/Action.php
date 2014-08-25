<?php
class Site_Controller_Action extends Zend_Controller_Action{
    protected $userSession;
    public function init()
    {
        $auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->userSession->hataMesaji="Giriş Yetkiniz Bulunmamaktadır!";
            $this->_redirect("/giris/index");
        }
        $this->userSession = new Zend_Session_Namespace('userSession');
        $this->view->userSession=$this->userSession;
        $this->view->bilgiMesaji=$this->userSession->bilgiMesaji;
        $this->view->hataMesaji=$this->userSession->hataMesaji;
    }
    public function preDispatch(){
        $this->userSession = new Zend_Session_Namespace('userSession');

        if($this->userSession->grup_kodu!=1){
            $acl = $this->userSession->acl;
            if($acl->has($this->getRequest()->getControllerName())){
                try{
                    if(!$acl->isAllowed($this->userSession->grup_kodu ,$this->_request->getControllerName(), $this->_request->getActionName())){
                        $this->userSession->hataMesaji="Yetkiniz yok!";
                        $this->_redirect('/giris/index');
                    }
                }
                catch(Zend_Exception $e){
                    echo $e->getMessage();exit;
                }
            }
            else{
                $this->userSession->hataMesaji="Yetkiniz yok?!";
                $this->_redirect('/giris/index');
            }
        }
    }
}