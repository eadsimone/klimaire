<?php

class Klimaire_WarrantyClaim_Model_Mysql4_Warrantyclaim extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the warrantyclaim_id refers to the key field in your database table.
        $this->_init('warrantyclaim/warrantyclaim', 'warrantyclaim_id');
    }
}