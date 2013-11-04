<?php
class Klimaire_PdfUpload_Block_Adminhtml_Pdfupload extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_pdfupload';
    $this->_blockGroup = 'pdfupload';
    $this->_headerText = Mage::helper('pdfupload')->__('PDF Manager');
    $this->_addButtonLabel = Mage::helper('pdfupload')->__('Add PDF');
    parent::__construct();
  }
}