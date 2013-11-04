<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Edit_Tab_Form8 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyclaim_form', array('legend'=>Mage::helper('warrantyclaim')->__('Extended Replacement Warranty information')));
     
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
	  
	 /* $fieldset->addField('extd_rplc_warranty_contractno', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Contract No.'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'extd_rplc_warranty_contractno',
      ));
	 
	 */
	 
	 	$read_core_handler = Mage::getSingleton('core/resource')->getConnection('core/read');
	$read_core_result = $read_core_handler->fetchAll("select extended_warranty from warrantyclaim where warrantyclaim_id = ".$this->getRequest()->getParam('id'));
		 
		  $checked_flag = $read_core_result[0]['extended_warranty'] == 1 ? true : false;
	  $fieldset->addField('extended_warranty', 'checkbox', array(
          'label'     => Mage::helper('warrantyclaim')->__('Did you purchase extended warranty ?'),		  
		  'name'      => 'extended_warranty',
          'checked'    => $checked_flag,
          'onclick'    => 'this.value = this.checked ? 1 : 0;'
      ));
  	  
	  $fieldset->addField('extendedwarrantybillnumber', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__("Extended warranty bill number"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'extendedwarrantybillnumber',
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