<?php

class EM_FlexibleWidget_Model_Mysql4_List_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('flexiblewidget/list');
    }
}