<?php

class Klimaire_WarrantyRegProd_Model_Mysql4_Warrantyregprod extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the warrantyregprod_id refers to the key field in your database table.
        $this->_init('warrantyregprod/warrantyregprod', 'warrantyregprod_id');
    }
}