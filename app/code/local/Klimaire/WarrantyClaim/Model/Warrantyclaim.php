<?php

class Klimaire_WarrantyClaim_Model_Warrantyclaim extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('warrantyclaim/warrantyclaim');
    }
}