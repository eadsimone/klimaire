<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Edit_Tab_Form2 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyclaim_form', array('legend'=>Mage::helper('warrantyclaim')->__('Product information')));
     
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
	  

		$coll = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect(array('sku')); //,'name','entity_id','status'));
			$prod_arr = array(''=>'Select Product');
			foreach($coll as $prod)
			{
				/*$tmp_prod_arr['value'] = $prod->getSku();
				$tmp_prod_arr['label'] = $prod->getName();
				$prod_arr[$prod->getId()] = $tmp_prod_arr;*/			
				$prod_arr[$prod->getSku()] = $prod->getSku();
			}
			
	$read_core_handler = Mage::getSingleton('core/resource')->getConnection('core/read');
	$read_core_result = $read_core_handler->fetchAll("select prodcode from warrantyclientdb");			
	
	foreach($read_core_result as $val)
	{
		$prodcode_arr[$val['prodcode']] = $val['prodcode'];
	}
	  $fieldset->addField('prod_code', 'text', array(
			  'label'     => Mage::helper('warrantyregprod')->__('Product Code'),
			  'required'  => true,
			  'name'      => 'prod_code',
			  'readonly'  => true,
		  ));	  
	  
	  $fieldset->addField('prod_srno', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Serial No.'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'prod_srno',
		   'readonly'  => true,
      ));

	  /*$fieldset->addField('prod_indr_userialno', 'text', array(
          'label'     => Mage::helper('warrantyclaim')->__('Indoor Unit Serial No.'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'prod_indr_userialno',
      ));*/

	  
	  $fieldset->addField(
			'prod_installedon', 
			'date', array(
				'label'     => 'Installed Date',
				'name'      => 'prod_installedon',
				'text'      => '',
				'format'    => 'yyyy-M-d HH:m:s',
				'time'      => false,
				'image'     => $this->getSkinUrl('images/grid-cal.gif'),
				'required'  => true,
			)
		);
		
	  $fieldset->addField(
			'prod_serviceon', 
			'date', array(
				'label'     => 'Service Date',
				'name'      => 'prod_serviceon',
				'text'      => '',
				'format'    => 'yyyy-M-d HH:m:s',
				'time'      => false,
				'image'     => $this->getSkinUrl('images/grid-cal.gif'),
				'required'  => true,
			)
		);	  

	  $fieldset->addField(
			'prod_purchasedon', 
			'date', array(
				'label'     => 'Purchased Date',
				'name'      => 'prod_purchasedon',
				'text'      => '',
				'format'    => 'yyyy-M-d HH:m:s',
				'time'      => false,
				'image'     => $this->getSkinUrl('images/grid-cal.gif'),
				'required'  => true,
			)
		);
	  


	  
     
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