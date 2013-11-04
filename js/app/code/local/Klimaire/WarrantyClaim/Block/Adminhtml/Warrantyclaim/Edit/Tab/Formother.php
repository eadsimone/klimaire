<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Edit_Tab_Formother extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyclaim_form', array('legend'=>Mage::helper('warrantyclaim')->__('Other information')));
     
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
	  
	  
	  /*$fieldset->addField('warrantytype', 'select', array(
          'label'     => Mage::helper('warrantyclaim')->__('Warranty Type'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'warrantytype',
		  'values' 	  =>	array(
              array(
                  'value'     => '',
                  'label'     => Mage::helper('warrantyclaim')->__('- Select -'),
              ),
			  
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('warrantyclaim')->__('Product Warranty'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('warrantyclaim')->__('Parts Warranty'),
              ),
              array(
                  'value'     => 3,
                  'label'     => Mage::helper('warrantyclaim')->__('Extended Warranty'),
              ),

              array(
                  'value'     => 4,
                  'label'     => Mage::helper('warrantyclaim')->__('SLA warranty'),
              ),			  			  
          ),		  
      ));*/



	
	$read_core_handler = Mage::getSingleton('core/resource')->getConnection('core/read');
	$read_core_result = $read_core_handler->fetchAll("select productwarranty,partswarranty,extendedwarranty,slawarranty from warrantyclaim where warrantyclaim_id = ".$this->getRequest()->getParam('id'));
	
	  $checked_flag = $read_core_result[0]['productwarranty'] == 1 ? true : false;
	  $fieldset->addField('productwarranty', 'checkbox', array(
          'label'     => Mage::helper('warrantyclaim')->__('Product Warranty'),          
          'name'      => 'productwarranty',
		  'value'      => 1,
		  'checked'    => $checked_flag,
		  'onclick'    => 'this.value = this.checked ? 1 : 0;'
      ));
	  
	  $checked_flag = $read_core_result[0]['partswarranty'] == 1 ? true : false;
	  $fieldset->addField('partswarranty', 'checkbox', array(
          'label'     => Mage::helper('warrantyclaim')->__('Parts Warranty'),          
          'name'      => 'partswarranty',		  
		  'checked'    => $checked_flag,
		  'onclick'    => 'this.value = this.checked ? 1 : 0;'
      ));
	  
	  $checked_flag = $read_core_result[0]['extendedwarranty'] == 1 ? true : false;
	  $fieldset->addField('extendedwarranty', 'checkbox', array(
          'label'     => Mage::helper('warrantyclaim')->__('Extended Warranty'),          		  
		  'name'      => 'extendedwarranty',
		  'checked'    => $checked_flag,
          'onclick'    => 'this.value = this.checked ? 1 : 0;'	  		  
      ));
	  
	  $checked_flag = $read_core_result[0]['slawarranty'] == 1 ? true : false;
	  $fieldset->addField('slawarranty', 'checkbox', array(
          'label'     => Mage::helper('warrantyclaim')->__('SLA Warranty'),		  
		  'name'      => 'slawarranty',
          'checked'    => $checked_flag,
          'onclick'    => 'this.value = this.checked ? 1 : 0;'
      ));
          $fieldset->addField('factory_use_only', 'textarea', array(
          'label'     => Mage::helper('warrantyclaim')->__('Factory Use Only.'),
          'wysiwyg'   => true,
          'required'  => false,
          'name'      => 'factory_use_only',
      ));
          $fieldset->addField('sp_auth_code', 'select', array(
          'label'     => Mage::helper('warrantyclaim')->__('Special Authorization Code'),
          'name'      => 'sp_auth_code',
          'onchange' => "changeSpAuthCodeNote(this.value);",
          'after_element_html' => '<small><span id="sp_auth_code_note"></span></small>',
          'values'    => array(
              array(
                  'value'     => 'Replacement part will be sent  free of charge & customer pays S&H. Please call 305-593-8358 to do necessary arrangements.',
                  'label'     => Mage::helper('warrantyclaim')->__('P1'),
              ),

              array(
                  'value'     => 'Warranty does not cover  your claim, you  may purchase the  replacement part & pay for S&H. Please call 305-593-8358 to do necessary arrangements.',
                  'label'     => Mage::helper('warrantyclaim')->__('P2'),
              ),
              array(
                  'value'     => 'You are authorized to purchase locally the failed part and  the moneys will be reimbursed.',
                  'label'     => Mage::helper('warrantyclaim')->__('P3'),
              ),
              array(
                  'value'     => 'Your unit will be replaced with a new one, you are obligated to pay S&H.',
                  'label'     => Mage::helper('warrantyclaim')->__('R1'),
              ),
              array(
                  'value'     => 'Your unit will be replaced with a refurbished one, you are obligated to pay S&H. Please call 305-593-8358 to do necessary arrangements.',
                  'label'     => Mage::helper('warrantyclaim')->__('R2'),
              ),
              array(
                  'value'     => 'Your extended warranty waves all charges,  S&H will be paid by customer. Please call 305-593-8358 to do necessary arrangements.',
                  'label'     => Mage::helper('warrantyclaim')->__('R3'),
              ),
          ),
      ));
	$fieldset->addField('sp_labour_allowance_amt', 'select', array(
          'label'     => Mage::helper('warrantyclaim')->__('Special Labour Allowance Amount'),
          'after_element_html' => '<small><span id="sp_labour_allowance_amt_note"></span></small>',
          'name'      => 'sp_labour_allowance_amt',
          'onchange' => "changeAllowanceText(this.value);",
          'values'    => array(
              array(
                  'value'     => 'Klimaire will reimburse you $40.00 to compensate the time allowance to make necessary repairs.',
                  'label'     => Mage::helper('warrantyclaim')->__('L1'),
              ),

              array(
                  'value'     => 'Klimaire will reimburse you $80.00 to compensate the time allowance to make necessary repairs.',
                  'label'     => Mage::helper('warrantyclaim')->__('L2'),
              ),
              array(
                  'value'     => 'Klimaire will reimburse you $120.00 to compensate the time allowance to make necessary repairs.',
                  'label'     => Mage::helper('warrantyclaim')->__('L3'),
              ),
              array(
                  'value'     => 'Klimaire will reimburse you $160.00 to compensate the time allowance to make necessary repairs.',
                  'label'     => Mage::helper('warrantyclaim')->__('L4'),
              ),
              array(
                  'value'     => 'Klimaire will reimburse you $200.00 to compensate the time allowance to make necessary repairs.',
                  'label'     => Mage::helper('warrantyclaim')->__('L5'),
              ),
              array(
                  'value'     => 'Klimaire will reimburse you $240.00 to compensate the time allowance to make necessary repairs.',
                  'label'     => Mage::helper('warrantyclaim')->__('L6'),
              ),
              array(
                  'value'     => 'Klimaire will reimburse you $280.00 to compensate the time allowance to make necessary repairs.',
                  'label'     => Mage::helper('warrantyclaim')->__('L7'),
              ),
              array(
                  'value'     => 'Klimaire will reimburse you $320.00 to compensate the time allowance to make necessary repairs.',
                  'label'     => Mage::helper('warrantyclaim')->__('L8'),
              ),
          ),
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