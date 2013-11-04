<?php

class Klimaire_PdfUpload_Block_Adminhtml_Pdfupload_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('pdfupload_form', array('legend'=>Mage::helper('pdfupload')->__('PDF information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('pdfupload')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

	  $getId_edit = $this->getRequest()->getParam('id'); 

	   if(isset($getId_edit))
	   {
		  $fieldset->addField('filename', 'file', array(
			  'label'     => Mage::helper('pdfupload')->__('upload PDF'),
			  'required'  => false,
			  'name'      => 'filename',
		  ));
		  
	   }
	   else
	   {
		  $fieldset->addField('filename', 'file', array(
			  'label'     => Mage::helper('pdfupload')->__('upload PDF'),
			  'class'     => 'required-entry',
			  'required'  => true,
			  'name'      => 'filename',
		  ));
		  
	  }
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('pdfupload')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('pdfupload')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('pdfupload')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('pdfupload')->__('Content'),
          'title'     => Mage::helper('pdfupload')->__('Content'),
          'style'     => 'width:650px; height:300px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
     
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