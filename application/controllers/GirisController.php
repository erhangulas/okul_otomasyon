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
                $tblgrup= new tblKullanici();
                $kullanici_adi=$this->getRequest()->getParam("kullanici_adi");
                $select=$tblgrup->select()->where("kullanici_adi=?",$kullanici_adi);
                $data=$tblgrup->fetchAll($select)->toArray();
                $kullanici=$data[0];
                $ses= new Zend_Session_Namespace('userSession');
                $grup_kodu= $kullanici['grup_kodu'] ? $kullanici['grup_kodu'] : 4;
                $acl= new Zend_Acl();
                $role= new Zend_Acl_Role($grup_kodu);

                $acl->addRole($role);
                $acl->add(new Zend_Acl_Resource('giris'));
                $acl->allow($grup_kodu,'giris','index');

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
