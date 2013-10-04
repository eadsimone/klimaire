<?php

class Klimaire_WarrantyRegProd_Block_Adminhtml_Warrantyregprod_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'warrantyregprod';
        $this->_controller = 'adminhtml_warrantyregprod';
        
        $this->_updateButton('save', 'label', Mage::helper('warrantyregprod')->__('Save Product'));
        $this->_updateButton('delete', 'label', Mage::helper('warrantyregprod')->__('Delete Product'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('warrantyregprod_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'warrantyregprod_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'warrantyregprod_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('warrantyregprod_data') && Mage::registry('warrantyregprod_data')->getId() ) {
            //return Mage::helper('warrantyregprod')->__("Edit %s ", '"'.ucfirst($this->htmlEscape(Mage::registry('warrantyregprod_data')->getProdtype())).'" [ProductCode:'.$this->htmlEscape(Mage::registry('warrantyregprod_data')->getProdcode().', SerialNo: '.$this->htmlEscape(Mage::registry('warrantyregprod_data')->getSerialno())).']');
			
			return Mage::helper('warrantyregprod')->__("Edit Info. : Registration/Confirmation Code: %s ", '"'.$this->htmlEscape(Mage::registry('warrantyregprod_data')->getConfirmcode().'"'));
			
        } else {
            return Mage::helper('warrantyregprod')->__('Add Product');
        }
    }
}