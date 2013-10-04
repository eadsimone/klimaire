<?php
class Klimaire_WarrantyRegProd_Block_Adminhtml_Warrantyregprod extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_warrantyregprod';
    $this->_blockGroup = 'warrantyregprod';
    $this->_headerText = Mage::helper('warrantyregprod')->__('Warranty Product Manager');
    $this->_addButtonLabel = Mage::helper('warrantyregprod')->__('Add Product');
    parent::__construct();
  }
}