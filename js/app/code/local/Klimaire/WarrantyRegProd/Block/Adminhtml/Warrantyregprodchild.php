<?php
class Klimaire_WarrantyRegProd_Block_Adminhtml_WarrantyregprodChild extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_warrantyregprodchild';
    $this->_blockGroup = 'warrantyregprodchild';
    $this->_headerText = Mage::helper('warrantyregprodchild')->__('Warranty Product Manager');
    $this->_addButtonLabel = Mage::helper('warrantyregprodchild')->__('Add Product');
    parent::__construct();
  }
}