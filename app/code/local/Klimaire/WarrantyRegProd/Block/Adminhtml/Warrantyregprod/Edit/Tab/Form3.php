<?php

class Klimaire_WarrantyRegProd_Block_Adminhtml_Warrantyregprod_Edit_Tab_Form3 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyregprod_form', array('legend'=>Mage::helper('warrantyregprod')->__('Installer information')));
     
      /*$fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('warrantyregprod')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));*/

	  $id = $this->getRequest()->getParam('id');
	  $EditMode = true;	  
	  if(!isset($id))
	  {
		$EditMode = false;
	  }

$fieldset->addField('inst_dealername', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer Dealer Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_dealername',
      ));

$fieldset->addField('inst_licenseno', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer License Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_licenseno',
      ));	

$fieldset->addField('inst_dealer_street', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer Dealer Street Address'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_dealer_street',
      ));

$fieldset->addField('inst_dealer_ph', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer Phone Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_dealer_ph',
      ));

$fieldset->addField('dealer_phno', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Dealer Phone Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'dealer_phno',
      ));

$fieldset->addField('inst_city', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_city',
      ));

$fieldset->addField('inst_state', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('State'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_state',
      ));

$fieldset->addField('inst_zip', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Zip'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_zip',
      ));

/*$fieldset->addField('inst_dealer_phno', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer Dealer Phone Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_dealer_phno',
      ));*/
	  
if($EditMode == false)
{
	$fieldset->addField('confirmcode', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Registration/Confirmation Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'confirmcode',
      ));
}
else
{
	$fieldset->addField('confirmcode', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Registration/Confirmation Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'readonly'  => true,		  
          'name'      => 'confirmcode',
      ));
}
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('warrantyregprod')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('warrantyregprod')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('warrantyregprod')->__('Disabled'),
              ),
          ),
      ));
     
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('warrantyregprod')->__('Content'),
          'title'     => Mage::helper('warrantyregprod')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getWarrantyRegProdData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getWarrantyRegProdData());
          Mage::getSingleton('adminhtml/session')->setWarrantyRegProdData(null);
      } elseif ( Mage::registry('warrantyregprod_data') ) {
          $form->setValues(Mage::registry('warrantyregprod_data')->getData());
      }
      return parent::_prepareForm();
  }
}