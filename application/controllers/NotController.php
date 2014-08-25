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


       $db=Zend_Db_Table::getDefaultAdapter();

        $sql = 'SELECT od.harf_notu, od.notu, od.id, o.adi, o.soyadi, o.fotograf, o.ogrenci_no FROM tbl_ogrenci_ders od, tbl_ogrenci o, tbl_ders_ogretmen do, tbl_ogretmen og
                WHERE do.ders_sinif_id = od.ders_sinif_id AND og.kullanici_id = do.ogretmen_id AND o.kullanici_id = od.ogrenci_id';

        $stmt = $db->query($sql);

        $data = $stmt->fetchAll();

        $this->view->data=$data;

    }
    public function duzenleAction(){

    }
    public function kaydetAction(){
        $post=$this->getRequest()->getPost();

        $tbl= new TblOgrenciDers();

        //post['notu'] veya post['harf_notu'] dizileri ayni indisli elemanlara sahip
        //iki diziden birini foreach ile donmek indisler icin kafi
        foreach($post['notu'] as $id => $not)
        {
            $data['notu']=$not;
            $data['harf_notu']=$post['harf_notu'][$id];
            $where = $tbl->getAdapter()->quoteInto("id=?",$id);
            $tbl->update($data,$where);
        }

        $this->_redirect("/not/giris");

    }

}