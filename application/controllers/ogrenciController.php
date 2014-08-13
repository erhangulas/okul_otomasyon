<?php
/**
 * Created by PhpStorm.
 * User: Erhan
 * Date: 12.08.2014
 * Time: 13:58
 */
class ogrenciController extends Site_Controller_Action{
    function init(){
        $auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->userSession->hataMesaji="Giriş Yetkiniz Bulunmamaktadır!";
            $this->_redirect("/giris/index");
        }
    }
    public function indexAction(){
        $ses= new Zend_Session_Namespace('userSession');
        $kullanici=$ses->kullanici;


        $tbl=new TblOgrenci();

        $select = $tbl->select()->where("kullanici_id=?", $kullanici['kullanici_adi']);

        $data=$tbl->fetchAll($select)->toArray();

        $this->view->data=$data[0];


    }
}