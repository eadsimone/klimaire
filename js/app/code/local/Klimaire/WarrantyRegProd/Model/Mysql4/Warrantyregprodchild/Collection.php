<?php

class Klimaire_WarrantyRegProd_Model_Mysql4_Warrantyregprodchild_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('warrantyregprod/warrantyregprodchild');
    }
}