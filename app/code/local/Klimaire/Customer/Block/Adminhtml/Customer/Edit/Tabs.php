<?php

class Klimaire_Customer_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Customer_Edit_Tabs {

    protected function _beforeToHtml() {
        
        if (Mage::registry('current_customer')->getId()) {

            $this->addTab('additional', array(
                'label' => Mage::helper('adminhtml')->__('Additional'),
                'content' => $this->getLayout()->createBlock('kcustomer/Adminhtml_Customer_Edit_Tab_Additional')->toHtml(),
            ));
        }
		
        return parent::_beforeToHtml();
    }

}
