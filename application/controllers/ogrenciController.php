<?php
/**
 * Created by PhpStorm.
 * User: Erhan
 * Date: 12.08.2014
 * Time: 13:58
 */
class ogrenciController extends Site_Controller_Action{

    public function indexAction(){
        $this->view->baslik = "ÖĞRENCİ LİSTESİ";
        $post = $this->getRequest()->getPost();
        $tbl = new TblOgrenci();
        $select=$tbl->select();

        if (sizeof($post))
        {
            foreach ($post as $key => $val)
            {
                if(strlen($val))
                    $select = $tbl->select()->where($key." like ?", "%".$val."%" );
            }
        }
        $data = $tbl->fetchAll($select)->toArray();
        $this->view->data = $data;


    }
    public function kaydetAction(){
        $post=$this->getRequest()->getPost();
        $tbl = new TblOgrenci();
        if(strlen($_FILES['fotograf']['tmp_name'])) //işte transparan kısım mesela böyle yapilir..
        {
            move_uploaded_file($_FILES['fotograf']['tmp_name'], ROOT_PUBLIC."/foto/".$_FILES['fotograf']['name']);
            $post['fotograf']=$_FILES['fotograf']['name']; //$post dizisine ne koyarsak db'ye o yazilir..
        }
//$id = $this->getRequest()->getParam('id');
        $id=$post['id'];//.unset(post['id']);
        unset($post['id']);
        if($id){
            $where = $tbl->getAdapter()->quoteInto("id=?",$id);
            if($tbl->update($post,$where)){
                $this->userSession->bilgiMesaji="Güncelleme İşlemi Gerçekleştirildi.";
            }
            else
                $this->userSession->hataMesaji="Güncelleme olamadi :(";
        }
        else{
            $id=$tbl->insert($post);
            if($id)
                $this->userSession->bilgiMesaji="Kaydetme İşlemi Gerçekleştirildi.";
            else
                $this->userSession->hataMesaji="Kaydetme başarısız";
        }
        $this->_redirect("/ogrenci/duzenle/id/".$id);

    }
    public function silAction(){
        $id = $this->getRequest()->getParam('id');
        if ($id)
        {
            $tbl = new TblOgrenci();
            $where = $tbl->getAdapter()->quoteInto('id=?',$id);
            $tbl->delete($where);
        }
        $this->_redirect("/ogrenci/index");
    }
    public function duzenleAction(){
        $id=$this->getRequest()->getParam("id"); //parametreyi aldik
        $tbl = new TblOgrenci();
        if($id)
        {
            $select = $tbl->select()->where("id=?", $id);
            $data=$tbl->fetchAll($select)->toArray();
            $this->view->data=$data[0];
        }

    }
    public function dersekleAction(){

    }
}