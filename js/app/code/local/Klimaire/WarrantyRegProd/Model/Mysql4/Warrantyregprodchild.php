<?php

class Klimaire_WarrantyRegProd_Model_Mysql4_Warrantyregprodchild extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the warrantyregprodID refers to the key field in your database table.
        $this->_init('warrantyregprod/warrantyregprodchild', 'id'); //warrantyregprodID
    }
}