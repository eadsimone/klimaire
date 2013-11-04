<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyclaim_form', array('legend'=>Mage::helper('warrantyclaim')->__('Registered information')));
     
      /*$fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('warrantyclaim')->__('File'),
          'required'  => false,
          'name'      => 'filename', 
	  ));*/
	  
	  $fieldset->addField('confirmcode', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Registration Code'),
		  'readonly'  => true,
          'name'      => 'confirmcode',
      ));
	  
	  $fieldset->addField('reg_fname', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Firstname'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'reg_fname',
      ));
	  
	  $fieldset->addField('reg_lname', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Lastname'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'reg_lname',
      ));
	  
	  	  $fieldset->addField('reg_addr1', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Address1'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'reg_addr1',
      ));
	  
	  $fieldset->addField('reg_addr2', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Address2'),
          'name'      => 'reg_addr2',
      ));
	  
	  $fieldset->addField('reg_zip', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Zip Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'reg_zip',
      ));
	  
  	  $fieldset->addField('reg_ph', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Phone No.'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'reg_ph',
      ));
	  
	  $fieldset->addField('reg_email', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'reg_email',
      ));	  
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('warrantyclaim')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('warrantyclaim')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('warrantyclaim')->__('Disabled'),
              ),
          ),
      ));


 
    	  $fieldset->addField('contact_ph', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__(' Current Phone No.'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_ph',
      ));	  
	  	  $fieldset->addField('contact_email', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Current Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_email',
      ));

	  	  $fieldset->addField('contact_addr1', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__(' Current Address'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_addr1',
      ));
	  
	  	  $fieldset->addField('contact_zip', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Current Zip Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_zip',
      ));	  
	  

     
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('warrantyclaim')->__('Content'),
          'title'     => Mage::helper('warrantyclaim')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getWarrantyClaimData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getWarrantyClaimData());
          Mage::getSingleton('adminhtml/session')->setWarrantyClaimData(null);
      } elseif ( Mage::registry('warrantyclaim_data') ) {
          $form->setValues(Mage::registry('warrantyclaim_data')->getData());
      }
      return parent::_prepareForm();
  }
}