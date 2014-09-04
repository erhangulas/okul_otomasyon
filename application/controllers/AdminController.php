<?php
/**
 * Created by PhpStorm.
 * User: Erhan
 * Date: 04.09.2014
 * Time: 14:19
 */
class AdminController extends Site_Controller_Action{

    public function indexAction(){
        $this->view->baslik="ADMİN LİSTESİ";
        $post = $this->getRequest()->getPost();
        $tbl = new TblKullanici();
        $select= $tbl->select()->where("grup_kodu=?",1);

        if (sizeof($post))
        {
            foreach ($post as $key => $val)
            {
                if(strlen($val))
                    $select = $tbl->select()->where($key." like ?", "%".$val."%" );
            }
        }
        $data= $tbl->fetchAll($select)->toArray();
        $this->view->data=$data;
    }

    public function duzenleAction(){
        $id=$this->getRequest()->getParam("id"); //parametreyi aldik
        $tbl = new TblKullanici();
        if($id)
        {
            $select = $tbl->select()->where("id=?", $id);
            $data=$tbl->fetchAll($select)->toArray();
            $this->view->data=$data[0];

        }
    }
    public function silAction(){
        $id = $this->getRequest()->getParam('id');
        if ($id)
        {
            $tbl = new TblKullanici();
            $where = $tbl->getAdapter()->quoteInto('id=?',$id);
            $tbl->delete($where);
        }
        $this->_redirect("/admin/index");
    }

    public function kaydetAction(){
        $post=$this->getRequest()->getPost();
        $post['grup_kodu']=1;
        $tbl = new TblKullanici();
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
        $this->_redirect("/admin/duzenle/id/".$id);
    }
}