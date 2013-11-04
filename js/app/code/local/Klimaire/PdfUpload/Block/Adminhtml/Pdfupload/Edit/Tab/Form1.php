<?php

class Klimaire_PdfUpload_Block_Adminhtml_Pdfupload_Edit_Tab_Form1 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('pdfupload_form', array('legend'=>Mage::helper('pdfupload')->__('Product Selection')));
     

	$coll = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect(array('name','entity_id','status'))
			->addAttributeToSort('name', 'asc');
	$prod_arr = array(''=>'Select Product');
	foreach($coll as $prod)
	{
		$tmp_prod_arr['value'] = $prod->getId();
		$tmp_prod_arr['label'] = $prod->getName();
		$prod_arr[$prod->getId()] = $tmp_prod_arr;
	}

      $fieldset->addField('product_id', 'multiselect', array(
          'label'     => Mage::helper('pdfupload')->__('Product'),
		 'required'  => true,
     	 'input'     => 'multiselect',
          'name'      => 'product_id',
          'values'    => $prod_arr,
      ));
	  
	   $fieldset->addField('tab_id', 'select', array(
          'label'     => Mage::helper('pdfupload')->__('Select Tab'),
          'name'      => 'tab_id',
          'values'    => array(
           
			  array(
                  'value'     => '0',
                  'label'     => Mage::helper('pdfupload')->__('Specification'),
              ),

              array(
                  'value'     => '1',
                  'label'     => Mage::helper('pdfupload')->__('Info & Guides'),
              ),
			  array(
                  'value'     => '2',
                  'label'     => Mage::helper('pdfupload')->__('Both'),
              ),
          ),
      ));
	  
	  
	  
	  /////////////////////////////
	/*  $coll2 = Mage::getModel('catalog/category')->getCollection()
			->addAttributeToSelect(array('name','entity_id','status'));
	$prod_arr2 = array(''=>'Select category');
	foreach($coll2 as $prod2)
	{
		$tmp_prod_arr2['value'] = $prod2->getId();
		$tmp_prod_arr2['label'] = $prod2->getName();
		$prod_arr2[$prod2->getId()] = $tmp_prod_arr2;
	}

      $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('pdfupload')->__('category'),
		
      
          'name'      => 'category_id',
          'values'    => $prod_arr2,
      ));*/
	  
	  
	  //////////////////////////////
     
      
	  
     
      if ( Mage::getSingleton('adminhtml/session')->getPdfUploadData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getPdfUploadData());
          Mage::getSingleton('adminhtml/session')->setPdfUploadData(null);
      } elseif ( Mage::registry('pdfupload_data') ) {
          $form->setValues(Mage::registry('pdfupload_data')->getData());
      }
      return parent::_prepareForm();
  }
}