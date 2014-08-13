<?php
class adminController extends Site_Controller_Action{
    function init(){
        $auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->userSession->hataMesaji="Giriş Yetkiniz Bulunmamaktadır!";
            $this->_redirect("/giris/index");
        }
    }
    public function indexAction(){

        $tbl=new TblYetki();

            //tblYetkiden sadece menude gozukecek olanları çekiyorum
        $select = $tbl->select()->where("grup_kodu=?", $this->userSession->grup_kodu)->where("durum=?", 1);

        $data=$tbl->fetchAll($select)->toArray();

        $this->view->menu=$data;
    }
}