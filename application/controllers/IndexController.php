<?php
class IndexController extends Site_Controller_Action{

    public function indexAction(){

        $tbl=new TblYetki();

            //tblYetkiden sadece menude gozukecek olanları çekiyorum
        $select = $tbl->select()->where("grup_kodu=?", $this->userSession->grup_kodu)->where("durum=?", 1);
        $data=$tbl->fetchAll($select)->toArray();

        foreach($data as $d)
        {
            $yeni[$d['ana_menu']][]=$d;
        }

        $this->view->yeni=$yeni;


        $select = $tbl->select()->from($tbl,"ana_menu")->where("grup_kodu=?", $this->userSession->grup_kodu)->where("durum=?", 1)->group("ana_menu");
        $data=$tbl->fetchAll($select)->toArray();
        $this->view->anamenu=$data;


    }
}