<?php

class EM_Catalogmenuwidget_Model_Catalogmenu extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('catalogmenuwidget/catalogmenu');
    }
}