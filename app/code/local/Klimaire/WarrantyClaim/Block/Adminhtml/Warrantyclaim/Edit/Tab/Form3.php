<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Edit_Tab_Form3 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyclaim_form', array('legend'=>Mage::helper('warrantyclaim')->__('Servicing Contractor information')));
     
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
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('warrantyclaim')->__('Content'),
          'title'     => Mage::helper('warrantyclaim')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
	  
	  $fieldset->addField('serv_contra_name', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Servicing Contractor Name'),
          'name'      => 'serv_contra_name',
      ));
	  
	  $fieldset->addField('serv_contra_addr', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__("Contractor's Street Address"),
          'name'      => 'serv_contra_addr',
      ));
	  
	  $fieldset->addField('serv_contra_city', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('City'),
          'name'      => 'serv_contra_city',
      ));
	  
	  $fieldset->addField('serv_contra_state', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('State'),
          'name'      => 'serv_contra_state',
      ));
	  
	  $fieldset->addField('serv_contra_zip', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Zip code'),
          'name'      => 'serv_contra_zip',
      ));
	  
	  $fieldset->addField('serv_contra_ph', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Phone No.'),
          'name'      => 'serv_contra_ph',
      ));
	  
	  $fieldset->addField('serv_contra_licenseno', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__("Contractor's License Number"),
          'name'      => 'serv_contra_licenseno',
      ));
	  
     
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