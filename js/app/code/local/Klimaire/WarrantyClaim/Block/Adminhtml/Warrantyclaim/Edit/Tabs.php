<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('warrantyclaim_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('warrantyclaim')->__('Warranty Claim Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('warrantyclaim')->__('Registered Information'),
          'title'     => Mage::helper('warrantyclaim')->__('Registered Information'),
          'content'   => $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit_tab_form')->toHtml(),
      ));
	  
      $this->addTab('form_section2', array(
          'label'     => Mage::helper('warrantyclaim')->__('Product Information'),
          'title'     => Mage::helper('warrantyclaim')->__('Product Information'),
          'content'   => $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit_tab_form2')->toHtml(),
      ));
	  
      $this->addTab('form_section3', array(
          'label'     => Mage::helper('warrantyclaim')->__('Servicing Contractor Information'),
          'title'     => Mage::helper('warrantyclaim')->__('Servicing Contractor Information'),
          'content'   => $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit_tab_form3')->toHtml(),
      ));
	  
      $this->addTab('form_section4', array(
          'label'     => Mage::helper('warrantyclaim')->__('Purchase from'),
          'title'     => Mage::helper('warrantyclaim')->__('Purchase from'),
          'content'   => $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit_tab_form4')->toHtml(),
      ));
	  
      $this->addTab('form_section5', array(
          'label'     => Mage::helper('warrantyclaim')->__('Reason of Failure (Selected from the window / table)'),
          'title'     => Mage::helper('warrantyclaim')->__('Reason of Failure (Selected from the window / table)'),
          'content'   => $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit_tab_form5')->toHtml(),
      ));
	  
      $this->addTab('form_section8', array(
          'label'     => Mage::helper('warrantyclaim')->__('Extended Replacement Warranty'),
          'title'     => Mage::helper('warrantyclaim')->__('Extended Replacement Warranty'),
          'content'   => $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit_tab_form8')->toHtml(),
      ));
	  
      $this->addTab('form_section_other', array(
          'label'     => Mage::helper('warrantyclaim')->__('Others'),
          'title'     => Mage::helper('warrantyclaim')->__('Others'),
          'content'   => $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit_tab_formother')->toHtml(),
      ));	  
	  
      return parent::_beforeToHtml();
  }
}