<?php
class Klimaire_PdfUpload_Block_Pdfupload extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getPdfUpload()     
     { 
        if (!$this->hasData('pdfupload')) {
            $this->setData('pdfupload', Mage::registry('pdfupload'));
        }
        return $this->getData('pdfupload');
        
    }
}