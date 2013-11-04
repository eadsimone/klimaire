<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Edit_Tab_Form5 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyclaim_form', array('legend'=>Mage::helper('warrantyclaim')->__('Reason of Failure information')));
     
    
	  $fieldset->addField('res_failure_failedcompocode', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Failed component code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'res_failure_failedcompocode',
      ));
	  
	  $fieldset->addField('res_failure_compocode', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Component code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'res_failure_compocode',
      ));
	  
	  $fieldset->addField('res_failure_causecode', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Cause code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'res_failure_causecode',
      ));
	  
	  
	   $fieldset->addField('res_failure_failedpartno1', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__("Failed Part No. 1"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'res_failure_failedpartno1',
      ));
	  
	   $fieldset->addField('res_failure_failedpartdescr1', 'textarea', array(
          'label'     => Mage::helper('warrantyclaim')->__("Description For Failed Part No. 1"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'res_failure_failedpartdescr1',
      ));
	  

	  $fieldset->addField('res_failure_replacement_pno1', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Replacement Part No. 1'),
          'name'      => 'res_failure_replacement_pno1',
          
      ));
          $fieldset->addField('res_failure_replacement_credit1', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Credit'),
          'name'      => 'res_failure_replacement_credit1',
          
      ));
          
          $fieldset->addField('res_failure_replacement_approval1', 'select', array(
          'label'     => Mage::helper('warrantyclaim')->__('Approved'),
          'name'      => 'res_failure_replacement_approval1',
          'values'    => array(
              array(
                  'value'     => 0,
                  'label'     => Mage::helper('warrantyclaim')->__('No'),
              ),

              array(
                  'value'     => 1,
                  'label'     => Mage::helper('warrantyclaim')->__('Yes'),
              ),
          ),
      ));
/***/
	   $fieldset->addField('res_failure_failedpartno2', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__("Failed Part No. 2"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'res_failure_failedpartno2',
      ));
	  
	   $fieldset->addField('res_failure_failedpartdescr2', 'textarea', array(
          'label'     => Mage::helper('warrantyclaim')->__("Description For Failed Part No. 2"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'res_failure_failedpartdescr2',
      ));
	  

	  $fieldset->addField('res_failure_replacement_pno2', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Replacement Part No. 2'),
          'name'      => 'res_failure_replacement_pno2',
          
      ));
          $fieldset->addField('res_failure_replacement_credit2', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Credit'),
          'name'      => 'res_failure_replacement_credit2',
          
      ));
          
          $fieldset->addField('res_failure_replacement_approval2', 'select', array(
          'label'     => Mage::helper('warrantyclaim')->__('Approved'),
          'name'      => 'res_failure_replacement_approval2',
          'values'    => array(
              array(
                  'value'     => 0,
                  'label'     => Mage::helper('warrantyclaim')->__('No'),
              ),

              array(
                  'value'     => 1,
                  'label'     => Mage::helper('warrantyclaim')->__('Yes'),
              ),
          ),
      ));

	  
	   $fieldset->addField('res_failure_failedpartno3', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__("Failed Part No. 3"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'res_failure_failedpartno3',
      ));
	  
	   $fieldset->addField('res_failure_failedpartdescr3', 'textarea', array(
          'label'     => Mage::helper('warrantyclaim')->__("Description For Failed Part No. 3"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'res_failure_failedpartdescr3',
      ));
	  

	  $fieldset->addField('res_failure_replacement_pno3', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Replacement Part No. 3'),
          'name'      => 'res_failure_replacement_pno3',
          
      ));
          $fieldset->addField('res_failure_replacement_credit3', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Credit'),
          'name'      => 'res_failure_replacement_credit3',
          
      ));
          
          $fieldset->addField('res_failure_replacement_approval3', 'select', array(
          'label'     => Mage::helper('warrantyclaim')->__('Approved'),
          'name'      => 'res_failure_replacement_approval3',
          'values'    => array(
              array(
                  'value'     => 0,
                  'label'     => Mage::helper('warrantyclaim')->__('No'),
              ),

              array(
                  'value'     => 1,
                  'label'     => Mage::helper('warrantyclaim')->__('Yes'),
              ),
          ),
      ));
  
	  	  $fieldset->addField('res_failure_srno1', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__("Fan Motor Serial Number"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'res_failure_srno1',
      ));

	  	  $fieldset->addField('res_failure_compressor', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__("Compressor Serial Number"),
          'readonly'     => 'true',
          'required'  => false,
          'name'      => 'res_failure_compressor',
      ));
	  
	  	  $fieldset->addField('reason_for_failure', 'textarea', array(
          'label'     => Mage::helper('warrantyclaim')->__("Reason for Failure"),
          'required'  => false,
          'name'      => 'reason_for_failure',
      ));

	  	  $fieldset->addField('service_performed', 'textarea', array(
          'label'     => Mage::helper('warrantyclaim')->__("Service Performed"),
          'required'  => false,
          'name'      => 'service_performed',
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