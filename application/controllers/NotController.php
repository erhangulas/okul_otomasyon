<?php
/**
 * Created by PhpStorm.
 * User: Erhan
 * Date: 19.08.2014
 * Time: 10:45
 */
class NotController extends Site_Controller_Action{

    public function indexAction(){
        $ses= new Zend_Session_Namespace('userSession');
        $kullanici=$ses->kullanici;

        $tbl=new Viogrenciders();

        $select = $tbl->select()->from($tbl);

        $data=$tbl->fetchAll($select)->toArray();

        $this->view->data=$data;


    }
    public function girisAction(){

        $ses= new Zend_Session_Namespace('userSession');

        $kullanici=$ses->kullanici;

        $tbl=new TblOgrenciDers();

        $select = $tbl->select()->where("ogrenci_id=?", $kullanici['kullanici_adi']);

        $data=$tbl->fetchAll($select)->toArray();

        $this->view->data=$data[0];
    }
    public function duzenleAction(){

    }
    public function kaydetAction(){

    }

}