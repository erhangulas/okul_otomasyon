<?php
class ErhangirisController extends Zend_Controller_Action{
	public function girisAction(){
			
	}
	public function kontrolAction(){

		$post=$this->getRequest()->getPost();

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
				$this->_redirect("erhangiris/giris");
			}
			else{
				$this->_redirect("erhan/index");
			}
		}
		catch(Zend_Exception $e){
			echo $e->getMessage();
		}
	}
	public function logoutAction(){
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect("erhangiris/giris");
	}
	public function kayitAction(){}

	public function kayittAction(){
		$post=$this->getRequest()->getPost();
		$post['parola']=md5($post['parola']);
		$post['tparola']=md5($post['tparola']);
		$tbl= new TblErhanUye();

		//$id=$tbl->insert($post);
		
		if($post['parola']!=$post['tparola']){
			
			$this->session->hataMesaji="Hatalı Parola";						
			$this->_redirect("erhangiris/kayit");
		}
		else{
			unset($post['tparola']);
		$id=$tbl->insert($post);	
        if($id)
          $this->session->bilgiMesaji="Kaydetme İşlemi Başarı İle Gerçekleştirildi.";
        else
          $this->session->hataMesaji="Kaydetme başarısız!!";

      $this->view->data = $post;
      $this->_redirect("erhangiris/giris");
	}}

}
