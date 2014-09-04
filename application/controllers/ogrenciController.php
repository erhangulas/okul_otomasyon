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
        $post1=$post;
        $durum=$post['durum'];
        $parola=$post['parola'];
        unset($post['id']);
        unset($post['durum']);
        unset($post['parola']);
        if($id){
            $where = $tbl->getAdapter()->quoteInto("id=?",$id);
            if($tbl->update($post,$where)){
                $tbl1= new TblKullanici();
                unset($post1['id']);
                unset($post1['fotograf']);
                unset($post1['dogum_yili']);
                unset($post1['velisi']);
                unset($post1['veli_telefon']);
                unset($post1['kullanici_id']);
                unset($post1['ogrenci_no']);
                unset($post1['k_id']);
                $where = $tbl1->getAdapter()->quoteInto("id=?",$post['k_id']);
                $tbl1->update($post1,$where);
                $this->userSession->bilgiMesaji="Güncelleme İşlemi Gerçekleştirildi.";
            }
            else
                $this->userSession->hataMesaji="Güncelleme olamadi :(";
        }
        else{
            $id=$tbl->insert($post);
            $tbl2= new TblKullanici();
            $data=array(
                'kullanici_adi' => $post['kullanici_id'],
                'parola'        => $parola,
                'adi'           => $post['adi'],
                'soyadi'        => $post['soyadi'],
                'durum'         => $durum,
                'grup_kodu'     => '3'
            );
            $tbl2->insert($data);
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
        $tbl1 = new TblKullanici();
        if($id)
        {
            $select = $tbl->select()->where("id=?", $id);
            $data=$tbl->fetchAll($select)->toArray();
            $this->view->data=$data[0];
            $select1 = $tbl1->select()->where("kullanici_adi=?",$data[0]['kullanici_id']);
            $data1=$tbl1->fetchAll($select1)->toArray();
            $this->view->data1=$data1[0];
        }

    }
    public function dersekleAction(){
        $id=$this->getRequest()->getParam('id');
        $tbl = new TblOgrenci();
        $select=$tbl->select()->where("id=?",$id);
        $data = $tbl->fetchAll($select)->toArray();
        $this->view->data = $data[0];
        $kullanici_id=$data[0]['kullanici_id'];
        $db=Zend_Db_Table::getDefaultAdapter();

        $sql='SELECT d.ders_adi, ds.id FROM tbl_ders d, tbl_ders_sinif ds,tbl_ogrenci_ders od, tbl_ogrenci o
        WHERE o.kullanici_id=od.ogrenci_id AND od.ders_sinif_id=ds.id AND ds.ders_id=d.id AND o.id='.$id;
        $stmt=$db->query($sql);
        $data1=$stmt->fetchAll();
        $this->view->data1=$data1;
        $ids = array();
        foreach($data1 as $d_id=>$id) {

            $ids[] = $id['id'];
        }
        if(sizeof($ids)){
           /* $tblDS = new TblDersSinif();
            $select2 = $tblDS->select()->where("id NOT IN(?)", $ids);
            $data2 = $tblDS->fetchAll($select2)->toArray();*/
            try{



            $sql1='SELECT ds.* FROM  tbl_ders_sinif ds, tbl_ogrenci_sube os, tbl_sinif_sube ss, tbl_ogrenci_ders od
            WHERE '.$kullanici_id.'=os.ogrenci_id AND os.ogrenci_id=od.ogrenci_id AND os.sube_id=ss.id  AND ds.sinif_id=ss.sinif_id AND ds.id NOT IN('.implode(",",$ids).')';
            $stmt1=$db->query($sql1);
            $data2=$stmt1->fetchAll();
            $ids = array();
            foreach($data2 as $d_id=>$id) {

                $ids[] = $id['ders_id'];
            }
            $tbl=new TblDers();
            $select2=$tbl->select()->where("id IN(?)",$ids);
            $data2= $tbl->fetchAll($select2)->toArray();
            $this->view->data2=$data2;
            }
            catch(Zend_Db_Exception $e){
               echo $e->getMessage();exit;
            }

        }
        else{
            try{
            $sql1='SELECT ds.* FROM  tbl_ders_sinif ds, tbl_ogrenci o, tbl_ogrenci_sube os, tbl_sinif_sube ss
        WHERE o.kullanici_id=os.ogrenci_id AND o.kullanici_id=os.ogrenci_id AND os.sube_id=ss.id  AND ds.sinif_id=ss.sinif_id AND o.id='.$id;
            $stmt1=$db->query($sql1);
            $data2=$stmt1->fetchAll();
            foreach($data2 as $d_id=>$id) {

                $ids[] = $id['ders_id'];
            }
            $tbl=new TblDers();
            $select2=$tbl->select()->where("id IN(?)",$ids);
            $data2= $tbl->fetchAll($select2)->toArray();
            $this->view->data2=$data2;
            }
            catch(Zend_Db_Exception $e){
                echo $e->getMessage();exit;
            }
        }

        /*$sql1='SELECT ds.id FROM  tbl_ders_sinif ds, tbl_ogrenci o, tbl_ogrenci_sube os, tbl_sinif_sube ss
        WHERE o.kullanici_id=os.ogrenci_id AND o.kullanici_id=os.ogrenci_id AND os.sube_id=ss.id  AND ds.sinif_id=ss.sinif_id AND o.id='.$id;
        $stmt1=$db->query($sql1);
        $data2=$stmt1->fetchAll();

        $this->view->data2=$data2;


            $sql1='SELECT ds.* FROM  tbl_ders_sinif ds, tbl_ogrenci_sube os, tbl_sinif_sube ss, tbl_ogrenci_ders od
            WHERE '.$kullanici_id.'=os.ogrenci_id AND os.ogrenci_id=od.ogrenci_id AND os.sube_id=ss.id  AND ds.sinif_id=ss.sinif_id AND ds.id NOT IN(?)'.$ids;
            $stmt1=$db->query($sql1);
            $data2=$stmt1->fetchAll();*/

    }
    public function derskaydetAction(){
        $post=$this->getRequest()->getPost();
        if($post){
            $tbl=new TblOgrenci();
            $select=$tbl->select()->where("id=?",$post['id']);
            $data = $tbl->fetchAll($select)->toArray()[0];

            $ogrenci_id=$data['kullanici_id'];
            $tblDS= new TblDersSinif();
            $select=$tblDS->select()->where("ders_id=?",$post['ders_id']);
            $data1 = $tbl->fetchAll($select)->toArray()[0];
            $ds_id=$data1['id'];
            $data=array(
                'ogrenci_id'=>$ogrenci_id,
                'ders_sinif_id'=>$ds_id
            );
            $tbl=new TblOgrenciDers();

            if($tbl->insert($data)){
                $this->userSession->bilgiMesaji="Ders Ekleme İşlemi Gerçekleştirildi.";
                $this->_redirect("/ogrenci/index");
            }
            else{
                $this->userSession->hataMesaji="Ders Ekleme başarısız";
                $this->_redirect("/ogrenci/index");
              }


        }
    }
}