<?php
/**
 * Created by PhpStorm.
 * User: Erhan
 * Date: 22.08.2014
 * Time: 16:54
 */
class DersController extends Site_Controller_Action{
    public function indexAction(){
        $this->view->baslik = "DERS LİSTESİ";
        $post = $this->getRequest()->getPost();

        $page=$post['page'] ? $post['page']  : 0;

        unset($post['page']);//veritabanında page diye bir sutun yok, aramada işi bulandirmasin..

        $tbl = new TblDers();
        $select=$tbl->select();

        if (sizeof($post))
        {
            foreach ($post as $key => $val)
            {
                if(strlen($val))
                    $select = $tbl->select()->where($key." like ?", "%".$val."%" );
            }
        }


        //$data = $tbl->fetchAll($select)->toArray();
        $this->view->data = Site_Helper::pagination($select, $page);
        $this->view->post=$post;
    }
    public function silAction(){
        $id = $this->getRequest()->getParam('id');
        if ($id)
        {
            $tbl = new TblDers();
            $where = $tbl->getAdapter()->quoteInto('id=?',$id);
            $tbl->delete($where);
        }
        $this->_redirect("/ders/index");
    }
    public function duzenleAction(){
        $id=$this->getRequest()->getParam("id"); //parametreyi aldik
        $tbl = new TblDers();
        if($id)
        {
            $select = $tbl->select()->where("id=?", $id);
            $data=$tbl->fetchAll($select)->toArray();
            $this->view->data=$data[0];
        }
    }
    public function kaydetAction(){
        $post=$this->getRequest()->getPost();
        $tbl = new TblDers();
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
        $this->_redirect("/ders/duzenle/id/".$id);
    }
}