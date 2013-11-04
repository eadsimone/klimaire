<?php
class Klimaire_WarrantyRegProd_Block_Warrantyregprod extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getWarrantyRegProd()     
     { 
        if (!$this->hasData('warrantyregprod')) {
            $this->setData('warrantyregprod', Mage::registry('warrantyregprod'));
        }
        return $this->getData('warrantyregprod');
        
    }
}