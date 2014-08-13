<?php
class GirisController extends Zend_Controller_Action{

	public function indexAction(){
			
	}
	public function kontrolAction(){

		$post=$this->getRequest()->getParams();

		$db=Zend_Db_Table::getDefaultAdapter();
		$authadapter=new Zend_Auth_Adapter_DbTable($db);

		$authadapter->setTableName("tbl_kullanici")
					->setIdentityColumn("kullanici_adi")
					->setCredentialColumn("parola")
					->setIdentity($post['kullanici_adi'])
					->setCredential(md5($post['parola']));
					
		$auth= Zend_Auth::getInstance();

		try{
			$result=$auth->authenticate($authadapter);
			if(!$result->isValid()){
				$this->_redirect("giris/index");
			}
			else{
                $ses= new Zend_Session_Namespace('userSession');
                $tblgrup= new tblKullanici();
                $kullanici_adi=$this->getRequest()->getParam("kullanici_adi");
                $select=$tblgrup->select()->where("kullanici_adi=?",$kullanici_adi);
                $data=$tblgrup->fetchAll($select)->toArray();
                $kullanici=$data[0];
                $ses->kullanici=$kullanici;
                $grup_kodu= $kullanici['grup_kodu'] ? $kullanici['grup_kodu'] : 4;
                $acl= new Zend_Acl();
                $role= new Zend_Acl_Role($grup_kodu);

                $acl->addRole($role);
                $acl->add(new Zend_Acl_Resource('admin'));
                $acl->allow($grup_kodu,'admin','index');

                $tblacl= new TblYetki();
                $select= $tblacl->select()->where("grup_kodu=?",$grup_kodu);
                $grupHak= $tblacl->fetchAll($select)->toArray();

                foreach ($grupHak as $gHak){
                    if(!$acl->has(new Zend_Acl_Resource($gHak['controller']))){
                        $acl->add(new Zend_Acl_Resource($gHak['controller']));
                    }
                    $acl->allow($gHak['grup_kodu'],$gHak['controller'],$gHak['action']);
                }
                $ses->acl = $acl;
                $ses->grup_kodu =$grup_kodu;

                $this->_redirect("admin/index");
/*

                switch($grup_kodu){
                    case 1:
                        $this->_redirect("admin/index");
                        break;
                    case 2:
                        $this->_redirect("ogretmen/index");
                        break;
                    case 3:
                        $this->_redirect("ogrenci/index");
                        break;
                    case 4:
                        $this->_redirect("giris/index");
                        break;
                }*/
			}
		}
		catch(Zend_Exception $e){
			echo $e->getMessage();
		}



	}
	public function logoutAction(){
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect("giris/index");
	}
	

}
