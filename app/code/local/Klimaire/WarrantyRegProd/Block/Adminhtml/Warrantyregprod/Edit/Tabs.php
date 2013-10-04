<?php

class Klimaire_WarrantyRegProd_Block_Adminhtml_Warrantyregprod_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('warrantyregprod_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('warrantyregprod')->__('Warranty Product Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('warrantyregprod')->__("1. - Owner's Information"),
          'title'     => Mage::helper('warrantyregprod')->__("1. - Owner's Information"),
          'content'   => $this->getLayout()->createBlock('warrantyregprod/adminhtml_warrantyregprod_edit_tab_form')->toHtml(),
      ));

	 $this->addTab('form_section2', array(
          'label'     => Mage::helper('warrantyregprod')->__('2. - Product Information'),
          'title'     => Mage::helper('warrantyregprod')->__('2. - Product Information'),
          'content'   => $this->getLayout()->createBlock('warrantyregprod/adminhtml_warrantyregprod_edit_tab_form2')->toHtml(),
      ));

	$this->addTab('form_section2_1', array(
          'label'     => Mage::helper('warrantyregprod')->__('2.1. - Product-Child info.'),
          'title'     => Mage::helper('warrantyregprod')->__('2.1. - Product-Child info.'),
          'content'   => $this->getLayout()->createBlock('warrantyregprod/adminhtml_warrantyregprod_edit_tab_formchildprod')->toHtml(),
      ));	       

	$this->addTab('form_section3', array(
          'label'     => Mage::helper('warrantyregprod')->__('3. - Installer Information'),
          'title'     => Mage::helper('warrantyregprod')->__('3. - Installer Information'),
          'content'   => $this->getLayout()->createBlock('warrantyregprod/adminhtml_warrantyregprod_edit_tab_form3')->toHtml(),
      ));

	

      return parent::_beforeToHtml();
  }
}