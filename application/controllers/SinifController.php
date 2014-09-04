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
        $post=$this->getRequest()->getPost();
        $post['sube_id']=$this->userSession->sube_id;
        $tbl=new TblOgrenciSube();
        if($tbl->insert($post)){
            $this->userSession->bilgiMesaji="Kaydetme İşlemi Gerçekleştirildi.";
            $this->_redirect("/sinif/index");
        }
        else{
            $this->userSession->hataMesaji="Kaydetme başarısız!";
            $this->_redirect("/sinif/index");
        }

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
        $ses= new Zend_Session_Namespace('userSession');
        $this->view->baslik = "ÖĞRENCİ LİSTESİ";
        $sube_id = $this->getRequest()->getParam('sube_id');
        $ses->sube_id=$sube_id;
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

                $tbl1=new TblOgrenciSube();
                $select=$tbl1->select('ogrenci_id');
                $ogrenciler=$tbl1->fetchAll($select)->toArray();
                $tblOgrenci1 = new TblOgrenci();
                $select = $tblOgrenci1->select()->where("kullanici_id NOT IN(?)", $ogrenciler);
                $data1 = $tblOgrenci1->fetchAll($select)->toArray();
                $this->view->data1=$data1;

                $html = $this->view->render('sinif/ajaxlistegetir.phtml');
                echo json_encode(array("err"=>0, "data"=>$html));
            }
            else{
                echo json_encode(array("err"=>1, "msg"=>"Şubede öğrenci yok."));
            }


        }
        exit;
    }

}