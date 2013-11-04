<?php

class Klimaire_WarrantyRegProd_Block_Adminhtml_Warrantyregprod_Edit_Tab_Form2 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyregprod_form', array('legend'=>Mage::helper('warrantyregprod')->__('Product information')));
     
      /*$fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('warrantyregprod')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));*/




			/*$fieldset->addField('prodtype', 'select', array(
				  'label'     => Mage::helper('warrantyregprod')->__('Product Type'),
				  'class'     => 'required-entry',
				  'required'  => true,
				  'name'      => 'prodtype',
				  'values'    => array(
									  array(
										  'value'     => 'residential',
										  'label'     => Mage::helper('warrantyregprod')->__('Residential'),
									  ),
						
									  array(
										  'value'     => 'commercial',
										  'label'     => Mage::helper('warrantyregprod')->__('Commercial'),
									  ),
								  )

			  ));
	  

			$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
			$_qur = "select prodcode from warrantyclientdb group by prodcode";
			$_res = $read_handler->query($_qur);
			$coll = $_res->fetchAll();
	
			//$coll = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect(array('sku')); //,'name','entity_id','status'));
			$prod_arr = array(''=>'Select Product');
			foreach($coll as $prod)
			{
				$prod_arr[trim($prod['prodcode'])] = trim($prod['prodcode']);
			}
	
		  $fieldset->addField('prodcode', 'select', array(
			  'label'     => Mage::helper('warrantyregprod')->__('Product Code'),
			  'class'     => 'required-entry',
			  'required'  => true,
			  'name'      => 'prodcode',
			  'values'    => $prod_arr,
		  ));		
		
		
		$fieldset->addField('serialno', 'text', array(
				  'label'     => Mage::helper('warrantyregprod')->__('Serial Number'),
				  'class'     => 'required-entry',
				  'required'  => true,
				  'name'      => 'serialno',
			  ));
		
		
		$fieldset->addField('indr_userialno', 'text', array(
				  'label'     => Mage::helper('warrantyregprod')->__('Indoor Unit Serial Number'),
				  'class'     => 'required-entry',
				  'required'  => true,
				  'name'      => 'indr_userialno',
			  ));*/
		
		$fieldset->addField('invoiceno', 'text', array(
				  'label'     => Mage::helper('warrantyregprod')->__('Invoice Number'),
				  'class'     => 'required-entry',
				  'required'  => true,
				  'name'      => 'invoiceno',
			  ));
		
		
		
		$fieldset->addField(
			'purchasedon', 
			'date', array(
				'label'     => 'Purchase Date',
				'name'      => 'purchasedon',
				'text'      => '',
				'format'    => 'yyyy-M-d HH:m:s',
				'time'      => false,
				'image'     => $this->getSkinUrl('images/grid-cal.gif'),
				'required'  => true,
			)
		);
		
			
		$fieldset->addField(
			'installedon', 
			'date', array(
				'label'     => 'Installation Date',
				'name'      => 'installedon',
				'text'      => '',
				'format'    => 'yyyy-M-d HH:m:s',
				'time'      => false,
				'image'     => $this->getSkinUrl('images/grid-cal.gif'),
				'required'  => true,
			)
		);
		
		$fieldset->addField('dealername', 'text', array(
				  'label'     => Mage::helper('warrantyregprod')->__('Dealer Name'),
				  'class'     => 'required-entry',
				  'required'  => true,
				  'name'      => 'dealername',
			  ));	


     
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('warrantyregprod')->__('Content'),
          'title'     => Mage::helper('warrantyregprod')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getWarrantyRegProdData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getWarrantyRegProdData());
          Mage::getSingleton('adminhtml/session')->setWarrantyRegProdData(null);
      } elseif ( Mage::registry('warrantyregprod_data') ) {
          $form->setValues(Mage::registry('warrantyregprod_data')->getData());
      }
      return parent::_prepareForm();
  }
}