<?php
class Klimaire_WarrantyClaim_Block_Warrantyclaim extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getWarrantyClaim()     
     { 
        if (!$this->hasData('warrantyclaim')) {
            $this->setData('warrantyclaim', Mage::registry('warrantyclaim'));
        }
        return $this->getData('warrantyclaim');
        
    }
}