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
	
	public function ajaxregionAction()
{
    $region1= $_REQUEST['region'];
	
    $response = '<option value="" selected >-Select State or Region-</option>';
    $regionCollection = Mage::getModel('directory/region_api')->items($region1);
     
    if(!empty($regionCollection))
    {
		foreach($regionCollection as $region) {
            $response.= '<option value="'.$region['name'] .'" >'. $region['name'].'</option>';
        }

    }
    $this->getResponse()->setBody($response);
}
	public function postAction() 
	 {
			$to = "vtajpara@sigmasolve.net";
			$subject = "My subject";
			$txt = "Hello world!";
			$headers = "From: vtajpara@sigmasolve.net" . "\r\n" .
			"CC: vjadeja@sigmasolve.net";			
			$simple_mail = mail($to,$subject,$txt,$headers);
			//var_dump($simple_mail);			
                        if($simple_mail)
                        {
                            Mage::getSingleton('core/session')->addSuccess('mail sent successfully.');
                        }
                        else
                        {
                            Mage::getSingleton('core/session')->addError("Error in sending email");
                        }
                        $this->_redirect('*/*/');
    }	



}

/*
public function postAction() 
	 {
		 $params = $this->getRequest()->getParams();
 
        $mail = new Zend_Mail();
        $mail->setBodyText($params['comment']);
        $mail->setFrom($params['email'], $params['name']);
        $mail->addTo('vtajpara@sigmasolve.net', 'Some Recipient');
        $mail->setSubject('Test ActiveCodeline_SimpleContact Module for Magento');
		echo $mail->setBodyText;
        try {
            $mail->send();
        }        
        catch(Exception $ex) {
            Mage::getSingleton('core/session')->addError('Error in sending email.');
 
        }
 
        //Redirect back to index action of (this) activecodeline-simplecontact controller
        //$this->_redirect('activecodeline-simplecontact/');

    }
*/