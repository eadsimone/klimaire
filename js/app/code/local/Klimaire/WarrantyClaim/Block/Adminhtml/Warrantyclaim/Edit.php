<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'warrantyclaim';
        $this->_controller = 'adminhtml_warrantyclaim';
        
        $this->_updateButton('save', 'label', Mage::helper('warrantyclaim')->__('Save Claim'));
        $this->_updateButton('delete', 'label', Mage::helper('warrantyclaim')->__('Delete Claim'));
	//$this->_updateButton('notify', 'label', Mage::helper('warrantyclaim')->__('Save Claim & Notify'));	
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        
        $this->_addButton('approve', array(
            'label'     => Mage::helper('adminhtml')->__('Approve'),
            'onclick'   => 'approve()',
            'class'     => 'save',
        ), -100);
		
		$this->_addButton('disapprove', array(
            'label'     => Mage::helper('adminhtml')->__('Disapprove'),
            'onclick'   => 'disapprove()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('warrantyclaim_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'warrantyclaim_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'warrantyclaim_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            function approve(){
                //alert($('edit_form').action);
				var tmptarget = $('edit_form').action
                editForm.submit(tmptarget.split('/save/').join('/approve/'));
            }
			function disapprove(){
                //alert($('edit_form').action);
				var tmptarget = $('edit_form').action
                editForm.submit(tmptarget.split('/save/').join('/disapprove/'));
            }
            
            document.getElementById('sp_auth_code_note').innerHTML = document.getElementById('sp_auth_code').value;
            function changeSpAuthCodeNote(tvalue){
                document.getElementById('sp_auth_code_note').innerHTML = tvalue;
            }
            
			function maxcredit(maxv)
			{
			if(maxv>150)
			{
				return false;
			}
			}
			
            //document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'Minimum | $40.00 | Upto 30 min. | Capacitor';
            changeAllowanceText(document.getElementById('sp_labour_allowance_amt').value);
            function changeAllowanceText(tmpvalue){
                if(tmpvalue == 'Klimaire will reimburse you $40.00 to compensate the time allowance to make necessary repairs.')
                {
                    document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'Minimum | $40.00 | Upto 30 min. | Capacitor';
                }
                if(tmpvalue == 'Klimaire will reimburse you $80.00 to compensate the time allowance to make necessary repairs.')
                {
                    document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'L1x2 | $80.00 | Upto 1 hr. | Outdoor motor, fan blade, contactor, solenoid coil, sensor, synchronized motor';
                }
                if(tmpvalue == 'Klimaire will reimburse you $120.00 to compensate the time allowance to make necessary repairs.')
                {
                    document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'L1x3 | $120.00 | Upto 1.5 hr. | Service valves, TXV, solenoid valve, indoor fan motor, switches';
                }
                if(tmpvalue == 'Klimaire will reimburse you $160.00 to compensate the time allowance to make necessary repairs.')
                {
                    document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'L1x4 | $160.00 | Upto 2 hr. | Reversing valve, blower wheel, PCB, ignition';
                }
                if(tmpvalue == 'Klimaire will reimburse you $200.00 to compensate the time allowance to make necessary repairs.')
                {
                    document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'L1x5 | $200.00 | Upto 2.5 hr. | Mini-split compressor, pumps, gas valves';
                }
                if(tmpvalue == 'Klimaire will reimburse you $240.00 to compensate the time allowance to make necessary repairs.')
                {
                    document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'L1x6 | $240.00 | Upto 3 hr. | Inverter compressor, central AC compressor, inverter PCB';
                }
                if(tmpvalue == 'Klimaire will reimburse you $280.00 to compensate the time allowance to make necessary repairs.')
                {
                    document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'L1x7 | $280.00 | Upto 4 hr.';
                }
                if(tmpvalue == 'Klimaire will reimburse you $320.00 to compensate the time allowance to make necessary repairs.')
                {
                    document.getElementById('sp_labour_allowance_amt_note').innerHTML = 'L1x8 | $320.00 | Upto 5 hr. | Multi-split unit compressors';
                }
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('warrantyclaim_data') && Mage::registry('warrantyclaim_data')->getId() ) {
            return Mage::helper('warrantyclaim')->__("Edit Claim [Reg/Confirmation code '%s']", $this->htmlEscape(Mage::registry('warrantyclaim_data')->getConfirmcode()));
        } else {
            return Mage::helper('warrantyclaim')->__('Add Claim');
        }
    }
}