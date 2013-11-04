<?php
class Klimaire_Contactus_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Contact Us"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("contact us", array(
                "label" => $this->__("Contact Us"),
                "title" => $this->__("Contact Us")
		   ));

      $this->renderLayout(); 
	  
    }
	public function postAction() 
	 {
			$to = "vtajpara@sigmasolve.net";
			$subject = "My subject";
			$txt = "Hello world!";
			$headers = "From: vtajpara@sigmasolve.net" . "\r\n" .
			"CC: vjadeja@example.com";			
			$simple_mail = mail($to,$subject,$txt,$headers);
			var_dump($simple_mail);			
		 
    }
	
}