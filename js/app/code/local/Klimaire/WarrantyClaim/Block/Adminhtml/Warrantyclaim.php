<?php
class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_warrantyclaim';
    $this->_blockGroup = 'warrantyclaim';
    $this->_headerText = Mage::helper('warrantyclaim')->__('Warranty Claim Manager');
    $this->_addButtonLabel = Mage::helper('warrantyclaim')->__('Add Claim');
    parent::__construct();
  }
}