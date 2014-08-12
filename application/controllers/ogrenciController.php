<?php
/**
 * Created by PhpStorm.
 * User: Erhan
 * Date: 12.08.2014
 * Time: 13:58
 */
class ogrenciController extends Site_Controller_Action{
    public function indexAction(){
        $ses= new Zend_Session_Namespace('userSession');
        $post=$this->getRequest()->getParams();
        $kullanici=$ses->kullanici;

        $tbl=new TblOgrenci();


        $select = $tbl->select()->where("kullanici_id=?", $kullanici['kullanici_adi']);

        $data=$tbl->fetchAll($select)->toArray();

        $this->view->data=$data[0];


    }
}