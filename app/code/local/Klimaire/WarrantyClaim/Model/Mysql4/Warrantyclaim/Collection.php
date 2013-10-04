<?php

class Klimaire_WarrantyClaim_Model_Mysql4_Warrantyclaim_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('warrantyclaim/warrantyclaim');
    }
}