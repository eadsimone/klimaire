<?php
class Klimaire_Contactus_Adminhtml_ContactusbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Contact Request"));
	   $this->renderLayout();
    }
}