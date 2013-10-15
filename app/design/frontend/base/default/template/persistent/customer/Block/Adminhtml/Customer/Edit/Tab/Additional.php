<?php
    
class Klimaire_Customer_Block_Adminhtml_Customer_Edit_Tab_Additional extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('klimaire-adminhtml/customer/edit/tabs/additional.phtml');
    }
}