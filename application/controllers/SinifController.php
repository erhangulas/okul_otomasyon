<?php
/**
 * Created by PhpStorm.
 * User: Erhan
 * Date: 15.08.2014
 * Time: 11:54
 */
class SinifController extends Site_Controller_Action{

    public function indexAction(){
        $this->view->baslik = "SINIF LİSTESİ";
        $post = $this->getRequest()->getPost();
        $tbl= new TblSinif();
        $select=$tbl->select();
        $data=$tbl->fetchAll($select)->toArray();
        $this->view->data=$data;


    }

    public function ogrenciataAction(){

    }

    public function ajaxsubegetirAction(){
        //bu çıktının javascript olarak algilanmasi icin force ediyoruz...
        header("Content-type: application/javascript");

        $id=$this->getRequest()->getParam("id");
        $tbl= new TblSinifSube();
        $select=$tbl->select()->where("sinif_id=?",$id);
        $data=$tbl->fetchAll($select)->toArray();
        $this->view->data=$data;
        /*$data=array(
            array("id"=>10, "sube_adi"=>"A Şubesi"),
            array("id"=>20, "sube_adi"=>"B Şubesi")
        );*/




        echo json_encode($data);

        exit;
    }
    public function ajaxlistegetirAction(){

        //burda layout olmamali.. ama view olmali..
        $this->_helper->layout()->disableLayout();

        $this->view->baslik = "ÖĞRENCİ LİSTESİ";
        $sube_id = $this->getRequest()->getParam('sube_id');

        if($sube_id) {
            $tbl = new TblOgrenciSube();
            $select=$tbl->select()->from($tbl, 'ogrenci_id')->where("sube_id=?",$sube_id);

            $ogrenciId = $tbl->fetchAll($select)->toArray();

            $ids = array();
            foreach($ogrenciId as $ogrenci_id=>$id) {

                $ids[] = $id['ogrenci_id'];
            }

            if(sizeof($ids)) {
                $tblOgrenci = new TblOgrenci();
                $select2 = $tblOgrenci->select()->where("kullanici_id IN(?)", $ids);
                $data = $tblOgrenci->fetchAll($select2)->toArray();
                $this->view->data=$data;

                $html = $this->view->render('sinif/ajaxlistegetir.phtml');
                echo json_encode(array("err"=>0, "data"=>$html));
            }
            else
                echo json_encode(array("err"=>1, "msg"=>"Şubede öğrenci yok."));
        }
        exit;
    }

}