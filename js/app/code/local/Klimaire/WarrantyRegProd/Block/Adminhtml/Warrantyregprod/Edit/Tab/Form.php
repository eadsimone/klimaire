<?php

class Klimaire_WarrantyRegProd_Block_Adminhtml_Warrantyregprod_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyregprod_form', array('legend'=>Mage::helper('warrantyregprod')->__("Owner's information")));
     
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


$fieldset->addField('fname', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Firstname'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'fname',
      ));

$fieldset->addField('lname', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Lastname'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'lname',
      ));

$fieldset->addField('addr1', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Address1'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'addr1',
      ));	

$fieldset->addField('apt', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Apt/Unit#'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'apt',
      ));

$fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'email',
      ));

$fieldset->addField('city', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'city',
      ));

	  // always Confirm these data to the FrontEnd Registration Form
	  $state_arr1 = array('','Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Georgia','Kentucky','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusets','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming','Florida'=>'Florida');
		

	  $state_arr = array_combine($state_arr1,$state_arr1);

      $fieldset->addField('state', 'select', array(
          'label'     => Mage::helper('warrantyregprod')->__('State'),
		  'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'state',
          'values'    => $state_arr,
      ));

$fieldset->addField('zipcode', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Zip Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'zipcode',
      ));

$fieldset->addField('phno', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Phone'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'phno',
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