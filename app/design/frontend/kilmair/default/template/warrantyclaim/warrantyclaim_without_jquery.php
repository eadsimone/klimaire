<?php
/*var_dump(Mage::getSingleton('admin/session')->isLoggedIn());
exit;
$base_path = Mage::getBaseDir('base');
$base_path = str_replace('\\',"/",$base_path);
require_once $base_path.'/app/Mage.php';


// Initialize Magento
Mage::app('default');

// This initalizes the session, using 'adminhtml' as the session name.
// Just ignore the returned Mage_Core_Model_Session instance
Mage::getSingleton('core/session', array('name' => 'adminhtml'));

// Get a singleton instance of the Mage_Admin_Model_Session class
// This is just the 'admin' namespace of the current session. (adminhtml in this case)
$session = Mage::getSingleton('admin/session');

// Use the 'admin/session' object to check loggedIn status
if ( $session->isLoggedIn() ) {
    echo "logged in";
} else {
    echo "not logged in";
}
exit;

Mage::app();
// Checking for admin session
//print_r(Mage::getSingleton('core/session', array('name'=>'adminhtml')));  exit;
$adminsession = Mage::getSingleton('admin/session', array('name'=>'adminhtml'));
print_r(get_class_methods($adminsession));
print_r(get_class($adminsession));
if($adminsession->isLoggedIn()) {
    echo "Admin Logged in";
} else {
    echo "Admin NOT logged in";
}
 //var_dump($_SESSION); 
 exit;   */
?>
<title>&lt;span class=&quot;mandatory_star_fields&quot; &gt;*&lt;/span&gt;</title>
<br />
<div class="page-title"><h1><?php echo $this->__('Warranty Claim') ?></h1></div>
<br />
<style type="text/css">
.validation-failed
{
    border-color: #EB340A !important;
    background-color: #FAEBE7 !important; 
}
.validation-advice {
    background-color: transparent;    
    clear: both;
    color: #EB340A;
     float:left;
    font-size: 10px;
    /*font-weight: bold;*/
    line-height: 13px;
    margin: 3px 0px 0px 0px;
    min-height: 13px;
    padding: 0 0 0 15px ;
}
.warranty_block_class
{ 
    background-color: #CCC; 
    padding: 2px; 
    border: 1px solid #000;
}
.mandatory_star_fields
{
    color: red;
    position:absolute;
}
table th.warranty_block_class
{
    text-align: right !important;
} 
.button-wattantyclim {background: none repeat scroll 0 0 #0D7F02;border: 1px solid #076300;color: #FFFFFF;cursor: pointer;height: 25px;padding: 0 2px;width: auto; margin:0 0 0 10px;}
</style>
<script type="text/javascript">
function warranty_custom_validation()
{        
    var warrantyType_obj = new Array('warrantytype_prod','warrantytype_parts','warrantytype_extended','warrantytype_sla');
	var len = warrantyType_obj.length;
    var chk_flg = false;
    for(var i=0; i<len; i++)
    {
        
		if(document.getElementById(warrantyType_obj[i]).checked == true)
        {
            chk_flg = true;
            break;
        }
    }
    
    if(!chk_flg)
    {
        //alert('Please, select the Type of Warrranty:\n[Product | Parts | Extended | SLA]');    
        document.getElementById('warrantytype_error_msg_id').style.display = 'block';
        return false;
    }
    else
    {
        document.getElementById('warrantytype_error_msg_id').style.display = 'none';
    }
    
    
    var len = (document.getElementsByName('contact_pt_radio').length);
    var contact_pt_radio_obj = document.getElementsByName('contact_pt_radio');
    var chk_flg = false;
    for(var i=0; i<len; i++)
    {
        if(contact_pt_radio_obj[i].checked == true)
        {
            chk_flg = true;
            var selected_index = i;
            break;
        }
    }
    
    if(!chk_flg)
    {        
        document.getElementById('contact_pt_error_msg_id1').style.display = 'block';
        return false;
        document.getElementById('contact_pt_error_msg_id2').style.display = 'none';
    }
    else
    {        
        document.getElementById('contact_pt_error_msg_id1').style.display = 'none';
        var contact_pt_val_as_id = contact_pt_radio_obj[selected_index].value; 
        
        if(document.getElementById(contact_pt_val_as_id).value == '')
        {                                    
            document.getElementById('contact_pt_error_msg_id2').style.display = 'block';
            return false;            
        }
        else
        {           
           document.getElementById('contact_pt_error_msg_id2').style.display = 'none';            
        }
        
            for(var i=0; i<len; i++)
            {
                if(i != selected_index)
                {
                    var contact_pt_val_as_id = contact_pt_radio_obj[i].value
                    document.getElementById(contact_pt_val_as_id).value = '';                    
                }
            }                    
        
    }    
    
}
</script>
<script type="text/javascript">
function RegCode_handlerFunction(){

// Write These codes only after form Validation
 
// Making Ajax Request
        var request = new Ajax.Request(
            //Defining Ajax Request URL, We are calling custom Controller Ns_Mylogin_AccountController Class (Defined Below)
            '<?php echo $this->getUrl("warrantyclaim/index/ajax/"); ?>',
            {
                method: 'post',
                onComplete: function(transport){ // Defining Complete Callback Function
 
                    // Getting Ajax Response Text Which is JSON Object
                    var jsonResponse = eval(transport.responseText);
                    
                    //Checking JSON Objects property and performing related action
                    // You will understand the response Text format after going through the controller description (Below)
                    
                    /*for(key in jsonResponse)
                    {
                        alert(key+' '+jsonResponse[key]);
                    }*/
                    
                    /*jQuery.each(jsonResponse, function(key, val) {
                      alert(key + "=" + val);
                    });*/
                    
                    if(jsonResponse[0] == 'true'){                        
                            
                            document.getElementById('reg_code_error_msg_id').style.display = 'block';
                            document.getElementById('reg_code').className = 'validation-failed';                            
                            if(divObj = document.getElementById('advice-required-entry-reg_code') && document.getElementById('advice-required-entry-reg_code').style.display == 'none')
                            document.getElementById('advice-required-entry-reg_code').style.display = 'block';
                                                        
                        
                            document.getElementById('reg_fname').value = '';
                            document.getElementById('reg_fname').className = 'validation-failed';                            
                            if(divObj = document.getElementById('advice-required-entry-reg_fname') && document.getElementById('advice-required-entry-reg_fname').style.display == 'none')
                            document.getElementById('advice-required-entry-reg_fname').style.display = 'block';

                            
                            document.getElementById('reg_lname').value = '';
                            document.getElementById('reg_lname').className = 'validation-failed';                            
                            if(divObj = document.getElementById('advice-required-entry-reg_lname') && document.getElementById('advice-required-entry-reg_lname').style.display == 'none')
                            document.getElementById('advice-required-entry-reg_lname').style.display = 'block';
                                                        
                            document.getElementById('reg_addr1').value = '';
                            document.getElementById('reg_addr1').className = 'validation-failed';                 
                            if(divObj = document.getElementById('advice-required-entry-reg_addr1') && document.getElementById('advice-required-entry-reg_addr1').style.display == 'none')           
                            document.getElementById('advice-required-entry-reg_addr1').style.display = 'block';
                            
                            document.getElementById('reg_addr2').value = '';
                            /*document.getElementById('reg_addr2').className = 'validation-failed';                 
                            if(document.getElementById('advice-required-entry-reg_addr2').style.display == 'none')           
                            document.getElementById('advice-required-entry-reg_addr2').style.display = 'block';*/
                            
                            document.getElementById('reg_zip').value = '';
                            document.getElementById('reg_zip').className = 'validation-failed';                   
                            if(divObj = document.getElementById('advice-required-entry-reg_zip') && document.getElementById('advice-required-entry-reg_zip').style.display == 'none')         
                            document.getElementById('advice-required-entry-reg_zip').style.display = 'block';
                            
                            document.getElementById('reg_ph').value = '';
                            document.getElementById('reg_ph').className = 'validation-failed';                    
                            if(divObj = document.getElementById('advice-required-entry-reg_ph') && document.getElementById('advice-required-entry-reg_ph').style.display == 'none')        
                            document.getElementById('advice-required-entry-reg_ph').style.display = 'block';
                            
                            document.getElementById('reg_email').value = '';
                            document.getElementById('reg_email').className = 'validation-failed';                 
                            if(divObj = document.getElementById('advice-required-entry-reg_email') && document.getElementById('advice-required-entry-reg_email').style.display == 'none')           
                            document.getElementById('advice-required-entry-reg_email').style.display = 'block';
                            
                        return false;
                    }
                    else{
                            //alert(jsonResponse);
                            if(document.getElementById('reg_code_error_msg_id').style.display == 'block')
                            {
                                document.getElementById('reg_code_error_msg_id').style.display = 'none';    
                                document.getElementById('reg_code').className = '';
                                if (divObj = document.getElementById('advice-required-entry-reg_code'))
                                document.getElementById('advice-required-entry-reg_code').style.display = 'none';                                
                            }    
                            
                            if(jsonResponse[1] != undefined && jsonResponse[1] != '')
                            {
                                document.getElementById('reg_fname').value = jsonResponse[1];                                
                                document.getElementById('reg_fname').className = '';                            
                                if (divObj = document.getElementById('advice-required-entry-reg_fname'))
                                document.getElementById('advice-required-entry-reg_fname').style.display = 'none';    
                                
                            }                            
                            
                            if(jsonResponse[2] != undefined && jsonResponse[2] != '')                            
                            {
                                document.getElementById('reg_lname').value = jsonResponse[2];                                    
                                document.getElementById('reg_lname').className = '';
                                if (divObj = document.getElementById('advice-required-entry-reg_lname'))
                                document.getElementById('advice-required-entry-reg_lname').style.display = 'none';
                            }
                            
                            if(jsonResponse[3] != undefined && jsonResponse[3] != '')                            
                            {
                                document.getElementById('reg_addr1').value = jsonResponse[3];                                    
                                document.getElementById('reg_addr1').className = '';                            
                                if (divObj = document.getElementById('advice-required-entry-reg_addr1'))
                                document.getElementById('advice-required-entry-reg_addr1').style.display = 'none'; 
                            }
                            
                            if(jsonResponse[4] != undefined && jsonResponse[4] != '')
                            {
                                document.getElementById('reg_addr2').value = jsonResponse[4];                                
                                /*document.getElementById('reg_addr2').className = '';                  
                                if (divObj = document.getElementById('advice-required-entry-reg_addr2'))          
                                document.getElementById('advice-required-entry-reg_addr2').style.display = 'none';*/                                 
                            }
                            
                            if(jsonResponse[5] != undefined && jsonResponse[5] != '')
                            {
                                document.getElementById('reg_zip').value = jsonResponse[5];                                    
                                document.getElementById('reg_zip').className = '';      
                                if (divObj = document.getElementById('advice-required-entry-reg_zip'))                      
                                document.getElementById('advice-required-entry-reg_zip').style.display = 'none';                                 
                            }
                            
                            if(jsonResponse[6] != undefined && jsonResponse[6] != '')
                            {
                                document.getElementById('reg_ph').value = jsonResponse[6];                                    
                                document.getElementById('reg_ph').className = '';                       
                                if (divObj = document.getElementById('advice-required-entry-reg_ph'))     
                                document.getElementById('advice-required-entry-reg_ph').style.display = 'none';                                  
                            }
                            
                            if(jsonResponse[7] != undefined && jsonResponse[7] != '')
                            {
                                document.getElementById('reg_email').value = jsonResponse[7];                                    
                                document.getElementById('reg_email').className = '';                    
                                if (divObj = document.getElementById('advice-required-entry-reg_email'))        
                                document.getElementById('advice-required-entry-reg_email').style.display = 'none';                                      
                            }
                                           
                        //window.location.href=jsonResponse.url;
                        return true;
                    }
                },
                parameters: Form.serialize($("warranty_claim_Form"))    // Seriallizing the form input values
                //parameters: val
            }
        );
        
}

function textCounter(field, countfield, maxlimit) 
{
    if (field.value.length > maxlimit) // if too long...trim it!
    field.value = field.value.substring(0, maxlimit);
    // otherwise, update 'characters left' counter
    else 
    countfield.value = maxlimit - field.value.length;
}

</script>
<!--ToolTip Strats -->
<style type="text/css">
#NT_copy {
                background-color: #333333;
                color: #FFFFFF;
                font-weight: bold;
                font-size: 13px;
                font-family: "Trebuchet MS";
                width: 550px;
                left: 0;
                top: 0;
                padding: 4px;
                position: absolute;
                text-align: left;
                z-index: 20;
                -moz-border-radius: 0 10px 10px 10px;
                filter: progid: DXImageTransform.Microsoft.Alpha(opacity=87);
                 -moz-opacity: .87;
                -khtml-opacity:.87;
                 opacity:.87;
}
#NT_copy1 {
                background-color: #333333;
                color: #FFFFFF;
                font-weight: bold;
                font-size: 13px;
                font-family: "Trebuchet MS";
                width: 550px;
                left: 0;
                top: 0;
                padding: 4px;
                position: absolute;
                text-align: left;
                z-index: 20;
                -moz-border-radius: 0 10px 10px 10px;
                filter: progid: DXImageTransform.Microsoft.Alpha(opacity=87);
                 -moz-opacity: .87;
                -khtml-opacity:.87;
                 opacity:.87;
}
</style>
<script type="text/javascript">
        var $jq = jQuery.noConflict();
            $jq(document).ready(function(){
        $jq(".formInfo").tooltip({tooltipcontentclass:"mycontent"})
});;
</script>
<!--ToolTip Ends -->

<?php
if(!isset($_SESSION['warranty_claim_succ_data_submit_flag']))
{
    $_SESSION['warranty_claim_succ_data_submit_flag'] = false;    
}    
?>
<form action="<?php echo $this->getUrl('warrantyclaim/index/post/'); ?>" id="warranty_claim_Form" name="warranty_claim_Form" method="post"><!-- onsubmit="return RegCode_handlerFunction();">-->
<div class="warranty_block_class"><strong>IMPORTANT:</strong> INFORMATION REQUIRED IN SECTIONS 1 THRU 10 MUST BE FILLED OUT COMPLETELY AND ACCURATELY. INCOMPLETE CLAIMS CANNOT BE PROCESSED AND REIMBURSEMENTS WILL BE DELAYED.</div>
<br />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="left" valign="top" width="15"><input type="checkbox" name="productwarranty" id="warrantytype_prod" value="1"<?php if($_SESSION['warranty_claim_data_preserve']['productwarranty'] == 1){?> checked="checked"<?php }?> /></td>
    <td align="left" valign="top"><strong><label for="warrantytype_prod" class="required">Product Warranty</label></strong></td>
    <td align="left" valign="top" width="15"><input type="checkbox" name="partswarranty" id="warrantytype_parts" value="1"<?php if($_SESSION['warranty_claim_data_preserve']['partswarranty'] == 1){?> checked="checked"<?php }?> /></td>
    <td align="left" valign="top"><strong><label for="warrantytype_parts" class="required">Parts Warranty</label></strong></td>
    <td align="left" valign="top" width="15"><input type="checkbox" name="extendedwarranty" id="warrantytype_extended" value="1"<?php if($_SESSION['warranty_claim_data_preserve']['extendedwarranty'] == 1){?> checked="checked"<?php }?> /></td>
    <td align="left" valign="top"><strong><label for="warrantytype_extended" class="required">Extended Warranty</label></strong></td>
    <td align="left" valign="top" width="15"><input type="checkbox" name="slawarranty" id="warrantytype_sla" value="1"<?php if($_SESSION['warranty_claim_data_preserve']['slawarranty'] == 1){?> checked="checked"<?php }?> /></td>
    <td align="left" valign="top"><strong><label for="warrantytype_sla" class="required">SLA warranty</label></strong></td>
  </tr>
  <tr><td colspan="8" align="center" valign="top"><div class="validation-advice" id="warrantytype_error_msg_id" style="display: none;">Please, select the Type of Warrranty: [Product | Parts | Extended | SLA]</div></td></tr>
  </table>
<br />
<div>If you forgot your registration code search by registered look up method: First name and Last name.</div>
<br />
<div class="warranty_block_class"><strong>1. - Registered Information (?)</strong></div>
<br />
<table width="100%" border="0" cellspacing="3" cellpadding="1">

<!-- 
  <tr>
    <th width="23%" align="right" valign="top"><label for="reg_code" class="required">Registration Code:</label></th>
    <td width="16%"><input type="text" name="reg_code" class="input-text required-entry" id="reg_code" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_code']; ?>" onkeyup="RegCode_handlerFunction();" />
    <div class="validation-advice" id="reg_code_error_msg_id" style="display: none;">Invalid Registration code.</div>
    </td>
    <td width="61%" align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>  
  -->

<!--  <tr><td colspan="3" height="30" align="left" valign="top">
<table width="100%" border="0" cellspacing="1" cellpadding="1" align="center">
-->
  <!--	
  <tr>
    <td align="left" valign="top" width="15"><input type="radio" name="contact_pt_radio" id="zip_radio" value="zip"<?php if($_SESSION['warranty_claim_data_preserve']['contact_pt_radio'] == 'zip'){?> checked="checked"<?php }?> /></td>
    <td align="left" valign="top" width="85"><strong><label for="zip_radio" class="required">Zip Code:</label></strong></td>
    <td align="left" valign="top"><input type="text" name="zip" id="zip" value="<?php echo $_SESSION['warranty_claim_data_preserve']['zip']; ?>" onclick="javascript:document.getElementById('zip_radio').checked = true;" /></td>
    <td align="left" valign="top" width="15"><input type="radio" name="contact_pt_radio" id="phno_radio" value="phno"<?php if($_SESSION['warranty_claim_data_preserve']['contact_pt_radio'] == 'phno'){?> checked="checked"<?php }?> /></td>
    <td align="left" valign="top" width="85"><strong><label for="phno_radio" class="required">Phone No. :</label></strong></td>
    <td align="left" valign="top"><input type="text" name="phno" id="phno" value="<?php echo $_SESSION['warranty_claim_data_preserve']['phno']; ?>" onclick="javascript:document.getElementById('phno_radio').checked = true;" /></td>
    <td align="left" valign="top" width="15"><input type="radio" name="contact_pt_radio" id="srno_radio" value="srno"<?php if($_SESSION['warranty_claim_data_preserve']['contact_pt_radio'] == 'srno'){?> checked="checked"<?php }?> /></td>
    <td align="left" valign="top" width="85"><strong><label for="srno_radio" class="required">Serial No. :</label></strong></td>
    <td align="left" valign="top"><input type="text" name="srno" id="srno" value="<?php echo $_SESSION['warranty_claim_data_preserve']['srno']; ?>" class="validate-serial-number" onclick="javascript:document.getElementById('srno_radio').checked = true;" /></td>    
  </tr>
  <tr><td colspan="9" align="left" valign="top">
  <div class="validation-advice" id="contact_pt_error_msg_id1" style="display: none;">Please, select Contact point</div>
  <div class="validation-advice" id="contact_pt_error_msg_id2" style="display: none;">Please, input the respective data.</div>
  </td></tr>
  -->


  
  
<!-- </table>  
  </div>
  </td></tr>
-->
  <tr>
     <th width="23%" align="right" valign="top"><label for="reg_code" class="required">Search by:</label></th>&nbsp;&nbsp;

    <td  valign="top" width="15">&nbsp;&nbsp;&nbsp;<input type="radio" name="contact_pt_radio" id="regi_code" value="regi_code"<?php //if($_SESSION['warranty_claim_data_preserve']['contact_pt_radio'] == 'zip'){?> checked="checked"<?php //}?> />
    <strong><label for="reg_code" class="required">Registration Code:</label></strong></td>
<!--  <td align="left" valign="top"><input type="text" name="regi_code" class="input-text required-entry" id="reg_code" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_code']; ?>" onkeyup="RegCode_handlerFunction();" /></td>
-->

    <td  valign="top" width="15"><input type="radio" name="contact_pt_radio" id="srno_radio" value="srno"<?php if($_SESSION['warranty_claim_data_preserve']['contact_pt_radio'] == 'srno'){?> checked="checked"<?php }?> />
<strong><label for="srno_radio" class="required">Serial No:</label></strong></td>
<!--    <td align="left" valign="top"><input type="text" name="srno" id="srno" value="<?php echo $_SESSION['warranty_claim_data_preserve']['srno']; ?>" class="validate-serial-number" onclick="javascript:document.getElementById('srno_radio').checked = true;" /></td>
-->
</tr>

  

    <tr>
    <th width="23%" align="right" valign="top"><strong><label for="reg_code" class="required">Registration Code:</label></strong></td>
    <td width="16%"><input type="text" name="regi_code" class="input-text required-entry" id="reg_code" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_code']; ?>"/></td>    
    <td width="61%" align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
    </tr>

    <tr>
    <th width="23%" align="right" valign="top"><strong><label for="srno_radio" class="required">Serial No:</label></strong></td>
    <td width="16%"><input type="text" name="srno" id="srno" class="input-text required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['srno']; ?>" class="validate-serial-number" /></td>
    </tr>
  
  <tr>
    <th width="23%" align="right" valign="top"><label for="reg_fname" class="required">Firstname:</label></th>
    <td width="16%"><input type="text" name="reg_fname" class="input-text required-entry" id="reg_fname" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_fname']; ?>" /></td>
    <td width="61%" align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>
  <tr>
    <th align="right" valign="top"><label for="reg_lname" class="required">Lastname:</label></th>
    <td><input type="text" name="reg_lname" class="input-text required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_lname']; ?>" id="reg_lname" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>
  <tr>
    <th align="right" valign="top"><label for="reg_addr1" class="required">Address1:</label></th>
    <td><input type="text" name="reg_addr1" class="input-text required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_addr1']; ?>" id="reg_addr1" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>
  <tr>
    <th align="right" valign="top"><label for="reg_addr2" class="required">Apt/Unit#:</label></th>
    <td><input type="text" name="reg_addr2" class="input-text" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_addr2']; ?>" id="reg_addr2" /></td>
    <td align="left" valign="top">&nbsp;<!--<span class="mandatory_star_fields">*</span>--></td>
  </tr>
  <tr>
    <th align="right" valign="top"><label for="reg_zip" class="required">Zip Code:</label></th>
    <td><input type="text" name="reg_zip" class="input-text required-entry validate-zip" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_zip']; ?>" id="reg_zip" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>
  <tr>
    <th align="right" valign="top"><label for="reg_ph" class="required">Phone:</label></th>
    <td><input type="text" name="reg_ph" class="input-text required-entry validate-phoneStrict" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_ph']; ?>" id="reg_ph" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>  
  <tr>
    <th align="right" valign="top"><label for="reg_email" class="required">Email:</label></th>
    <td><input name="reg_email" id="reg_email" class="input-text required-entry validate-email" type="text" value="<?php echo $_SESSION['warranty_claim_data_preserve']['reg_email']; ?>" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>  
</table>
<br />
<div class="warranty_block_class"><strong>2. - Current Contact Information</strong></div>

<table width="100%" border="0" cellspacing="3" cellpadding="1">

    <tr>
    <th width="23%" align="right" valign="top"><strong><label for="contact_ph" class="required">Phone:</label></strong></td>
    <td width="16%"><input type="text" name="contact_ph" class="input-text required-entry validate-phoneStrict" value="<?php //echo $_SESSION['warranty_claim_data_preserve']['reg_ph']; ?>" id="contact_ph" /></td>    
    <td width="61%" align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
    </tr>
  <tr>
    <th align="right" valign="top"><label for="contact_email" class="required">Email:</label></th>
    <td><input name="contact_email" id="contact_email" class="input-text required-entry validate-email" type="text" value="<?php //echo $_SESSION['warranty_claim_data_preserve']['reg_email']; ?>" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>
    <tr>
    <th align="right" valign="top"><label for="contact_addr1" class="required">Address:</label></th>
    <td><input type="text" name="contact_addr1" class="input-text required-entry" value="<?php //echo $_SESSION['warranty_claim_data_preserve']['reg_addr1']; ?>" id="rcontact_addr1" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>
  <tr>
    <th align="right" valign="top"><label for="contact_zip" class="required">Zip Code:</label></th>
    <td><input type="text" name="contact_zip" class="input-text required-entry validate-zip" value="<?php //echo $_SESSION['warranty_claim_data_preserve']['reg_zip']; ?>" id="contact_zip" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>
</table>


<br />
<div class="warranty_block_class"><strong>3. - Product Information (?)</strong></div>
<br />
<table width="100%" border="0" cellspacing="3" cellpadding="1">    
  <tr>
    <th align="right" valign="top"><label for="prod_code" class="required">Product Code:</label></th>
    <td width="17%">
    <?php     
    $read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
    $_qur = "select prodcode from warrantyclientdb group by prodcode";
    $_res = $read_handler->query($_qur);
    $_rows = $_res->fetchAll();    
    
    /*$SKU_coll = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('sku');
    $SKU_data_coll = $SKU_coll->getData();*/    
    if(count($_rows) > 0)
    {
    ?>    
    <select name="prod_code" class="input-text validate-select" id="prod_code" style="width:150px">
    <option value="" selected>- Select Product Code-</option>
    <?php
        foreach($_rows as $v)
        {
        ?>
        <option value="<?php echo trim($v['prodcode']); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['prod_code'] == trim($v['prodcode'])){?> selected="selected"<?php }?>><?php echo trim($v['prodcode']); ?></option>        
        <?php    
        }
    ?>
    </select>
    <?php    
    }
    ?>
    </td>
    <td width="61%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <th align="right" valign="top"><label for="prod_srno" class="required">Serial Number:</label></th>
    <td><input type="text" name="prod_srno" class="input-text required-entry validate-serial-number" value="<?php echo $_SESSION['warranty_claim_data_preserve']['prod_srno']; ?>" id="prod_srno" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>  
  <tr>
    <th align="right" valign="top"><label for="prod_installedon" class="required">Date Installed:</label></th>
    <td><input type="text" name="prod_installedon" class="input-text required-entry validate-date" value="<?php echo $_SESSION['warranty_claim_data_preserve']['prod_installedon']; ?>" id="prod_installedon" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>  
  <tr>
    <th align="right" valign="top"><label for="prod_serviceon" class="required">Last Service Date:</label></th>
    <td><input type="text" name="prod_serviceon" class="input-text required-entry validate-date" value="<?php echo $_SESSION['warranty_claim_data_preserve']['prod_serviceon']; ?>" id="prod_serviceon" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span></td>
  </tr>
  <tr>
    <th align="right" valign="top"><label for="prod_purchasedon" class="required">Purchase Date:</label></th>
    <td><input type="text" name="prod_purchasedon" class="input-text required-entry validate-date" value="<?php echo $_SESSION['warranty_claim_data_preserve']['prod_purchasedon']; ?>" id="prod_purchasedon" /></td>
    <td align="left" valign="top">&nbsp;<span class="mandatory_star_fields">*</span>&nbsp;&nbsp;[To be proved as per Limited warranty conditions]</td>
  </tr>    
</table>  
<br />

<div class="warranty_block_class"><strong>4. - Servicing Contractor Information (?)</strong></div>
<br />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <th width="22%" align="left" valign="top"><label for="serv_contra_name" class="required">Servicing Contractor Name:</label></th>
    <td width="10%"><input type="text" name="serv_contra_name" id="serv_contra_name" class="required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['serv_contra_name']; ?>" /></td>
    <td colspan="4" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <th align="left" valign="top"><label for="serv_contra_addr" class="required">Contractor's Street Address:</label></th>
    <td><input type="text" name="serv_contra_addr" id="serv_contra_addr" class="required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['serv_contra_addr']; ?>" /></td>
    <td colspan="4" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <th align="left" valign="top"><label for="serv_contra_city" class="required">City:</label></th>
    <td width="25%"><input type="text" name="serv_contra_city" id="serv_contra_city" class="required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['serv_contra_city']; ?>" /></td>
    <th width="7%" align="left" valign="top"><label for="serv_contra_state" class="required">State:</label></th>
    <td><input type="text" name="serv_contra_state" id="serv_contra_state" class="required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['serv_contra_state']; ?>" /></td>
    <th width="5%" align="left" valign="top"><label for="serv_contra_zip" class="required">Zip:</label></th>
    <td><input type="text" name="serv_contra_zip" id="serv_contra_zip" class="required-entry validate-zip" value="<?php echo $_SESSION['warranty_claim_data_preserve']['serv_contra_zip']; ?>" /></td>
  </tr>
  <tr>
    <th align="left" valign="top"><label for="serv_contra_ph" class="required">Phone No.:</label></th>
    <td><input type="text" name="serv_contra_ph" id="serv_contra_ph" class="required-entry validate-phoneStrict" value="<?php echo $_SESSION['warranty_claim_data_preserve']['serv_contra_ph']; ?>" /></td>
    <td colspan="4" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <th align="left" valign="top"><label for="serv_contra_licenseno" class="required">Contractor's License Number:</label></th>
    <td><input type="text" name="serv_contra_licenseno" id="serv_contra_licenseno" class="required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['serv_contra_licenseno']; ?>" /></td>
    <td colspan="4" align="left" valign="top">&nbsp;</td>
  </tr>  
</table>
<br />

<div class="warranty_block_class"><strong>5. - Purchase from:</strong></div>
<br />
<table><tr><th><label for="purchasefrom_loc" class="required">Purchase from:</label></th><td><input type="text" name="purchasefrom_loc" id="purchasefrom_loc" class="required-entry" value="<?php echo $_SESSION['warranty_claim_data_preserve']['purchasefrom_loc']; ?>" /><span class="mandatory_star_fields" >*</span></td><th>&nbsp;&nbsp;&nbsp;&nbsp;<label for="purchasefrom_ph" class="required">Phone No. :</label></th><td><input type="text" name="purchasefrom_ph" id="purchasefrom_ph" class="required-entry validate-phoneStrict" value="<?php echo $_SESSION['warranty_claim_data_preserve']['purchasefrom_ph']; ?>" /><span class="mandatory_star_fields" >*</span></td></tr></table>
<br />

<div class="warranty_block_class"><strong>6. - Reason of Failure (Select from the window / table):</strong></div>
<br />
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="reason_failure">
<tr>
<th valign="top"><label for="res_failure_failedcompocode" class="required">Failed component code:</label></th>
<td>
<?php
$res_failure_failedcompocode_arr = array('Refrigerant System'=>'Refrigerant System','Compressor / Motors'=>'Compressor / Motors','Electrical Components'=>'Electrical Components','Non-Electrical Components'=>'Non-Electrical Components','Gas Furnace / Boiler'=>'Gas Furnace / Boiler');
?>
<select name="res_failure_failedcompocode" id="res_failure_failedcompocode" class="input-text validate-select" onchange="Reason_of_Failure_data(this.value)">
<option value="">- Select -</option>
<?php
    foreach($res_failure_failedcompocode_arr as $v):
?>
<option value="<?php echo $v; ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_failedcompocode'] == $v){?> selected="selected"<?php }?>><?php echo $v; ?></option>
<?php
    endforeach;
?>
</select>
&nbsp;<span class="mandatory_star_fields" >*</span>
</td>
<th valign="top"><label for="res_failure_compocode" class="required">Component code:</label></th>
<td>
<select name="res_failure_compocode" id="res_failure_compocode" class="input-text validate-select">
<option value="">- Select -</option>
</select>
<?php
$res_failure_compocode_arr1 = array('CC Coil - Condenser'=>'CC Coil - Condenser','CE Coil - Evaporator'=>'CE Coil - Evaporator','DC Distributor / Capillar'=>'DC Distributor / Capillar','FD Filter / Dryer'=>'FD Filter / Dryer','CV Check valve'=>'CV Check valve','EV Expansion valve'=>'EV Expansion valve',
'RV Reversing valve'=>'RV Reversing valve','SV Service valve'=>'SV Service valve','RT Refrigerant tubing'=>'RT Refrigerant tubing','OR Other refrig. Components'=>'OR Other refrig. Components');
?>
<select name="res_failure_compocode1" id="res_failure_compocode1" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_compocode_arr1 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_compocode1'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
<?php
$res_failure_compocode_arr2 = array('CP Compressor'=>'CP Compressor','EM Evaporator motor'=>'EM Evaporator motor','CM Condenser motor'=>'CM Condenser motor','OM Other motors'=>'OM Other motors');
?>
<select name="res_failure_compocode2" id="res_failure_compocode2" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_compocode_arr2 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_compocode2'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
<?php
$res_failure_compocode_arr3 = array('CN Controls'=>'CN Controls',
'CA Capacitor'=>'CA Capacitor',
'HL Heater elements'=>'HL Heater elements',
'SL Switches / Limits'=>'SL Switches / Limits',
'TH Thermostat'=>'TH Thermostat',
'MC Miscellaneous electrical'=>'MC Miscellaneous electrical',
'SV Solenoid valve'=>'SV Solenoid valve',
'SS Sensor'=>'SS Sensor',
'VG Valve gas'=>'VG Valve gas',
'VL Valves'=>'VL Valves',
'HX Heat exchanger'=>'HX Heat exchanger',
'PCB Control board'=>'PCB Control board',
'WH Wire harness'=>'WH Wire harness'
);
?>
<select name="res_failure_compocode3" id="res_failure_compocode3" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_compocode_arr3 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_compocode3'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
<?php
$res_failure_compocode_arr4 = array('FB Fan / blower'=>'FB Fan / blower',
'IN Insulation'=>'IN Insulation',
'MC Miscellaneous'=>'MC Miscellaneous',
'PC Piping connector'=>'PC Piping connector',
'NM Non-metal parts'=>'NM Non-metal parts',
'SM Sheet metal parts'=>'SM Sheet metal parts');
?>
<select name="res_failure_compocode4" id="res_failure_compocode4" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_compocode_arr4 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_compocode4'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
<?php
$res_failure_compocode_arr5 = array('HX Heat exchanger'=>'HX Heat exchanger',
'BR Burner / Pilot'=>'BR Burner / Pilot',
'RC Recoup coil / cover'=>'RC Recoup coil / cover',
'PS Pressure switch'=>'PS Pressure switch',
'PM Pump'=>'PM Pump',
'TV Three-way valve'=>'TV Three-way valve',
'GV LP / N Gas valve'=>'GV LP / N Gas valve',
'GG Gauge'=>'GG Gauge',
);
?>
<select name="res_failure_compocode5" id="res_failure_compocode5" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_compocode_arr5 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_compocode5'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
&nbsp;<span class="mandatory_star_fields" style="float:left;">*</span></td>
<th valign="top"><label for="res_failure_causecode" class="required">Cause code:</label></th>
<td>
<select name="res_failure_causecode" id="res_failure_causecode" class="input-text validate-select">
<option value="">- Select -</option>
</select>
<?php
$res_failure_causecode_arr1 = array('AJ Adjust'=>'AJ Adjust','BD Bent / dented'=>'BD Bent / dented','CM Condensation / Moisture'=>'CM Condensation / Moisture','CR Corrosion'=>'CR Corrosion','NC Not opening / Closing'=>'NC Not opening / Closing','OD Odor'=>'OD Odor','LB Leak / Broken'=>'LB Leak / Broken','RT Restricted'=>'RT Restricted','RV Rub / Vibration damage'=>'RV Rub / Vibration damage','SJ Solder joint leak / Crack'=>'SJ Solder joint leak / Crack','SL Slab leak'=>'SL Slab leak','ST Stuck / Sticking'=>'ST Stuck / Sticking','TL Tubinfg leak'=>'TL Tubinfg leak');
?>
<select name="res_failure_causecode1" id="res_failure_causecode1" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_causecode_arr1 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_causecode1'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
<?php
$res_failure_causecode_arr2 = array('BS Burnt / Short circuit'=>'BS Burnt / Short circuit',
'ET Electric terminals'=>'ET Electric terminals',
'LK Leak'=>'LK Leak',
'MW Motor leads / wiring'=>'MW Motor leads / wiring',
'NS Noise'=>'NS Noise',
'ST Stuck / Sticking (locked rotor)'=>'ST Stuck / Sticking (locked rotor)',
'VB Vibration'=>'VB Vibration',
'VV Valves'=>'VV Valves');
?>
<select name="res_failure_causecode2" id="res_failure_causecode2" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_causecode_arr2 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_causecode2'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
<?php
$res_failure_causecode_arr3 = array('AJ Adjust'=>'AJ Adjust',
'BS Burnt / Short circuited'=>'BS Burnt / Short circuited',
'ET Electric terminals'=>'ET Electric terminals',
'LK Leak'=>'LK Leak',
'LL Lock out / Lock up'=>'LL Lock out / Lock up',
'NC Not opening / Closing'=>'NC Not opening / Closing',
'SF Seal failure'=>'SF Seal failure',
'NR No response'=>'NR No response',
'ST Stuck / Sticking'=>'ST Stuck / Sticking');
?>
<select name="res_failure_causecode3" id="res_failure_causecode3" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_causecode_arr3 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_causecode3'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
<?php
$res_failure_causecode_arr4 = array('AJ Adjust'=>'AJ Adjust',
'CR Corroded / Rusted'=>'CR Corroded / Rusted',
'LT Loose / Torn'=>'LT Loose / Torn',
'NS Noise'=>'NS Noise',
'CK Cracked'=>'CK Cracked',
'LK Leak'=>'LK Leak',
'ST Stuck / Sticking'=>'ST Stuck / Sticking',
'VB Vibration'=>'VB Vibration');
?>
<select name="res_failure_causecode4" id="res_failure_causecode4" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_causecode_arr4 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_causecode4'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
<?php
$res_failure_causecode_arr5 = array('CR Corroded / Rusted'=>'CR Corroded / Rusted',
'CK Cracked'=>'CK Cracked',
'SO Sooted'=>'SO Sooted',
'LK Leak'=>'LK Leak',
'NR Nox Rods'=>'NR Nox Rods',
'MF Malfunctioning'=>'MF Malfunctioning');
?>
<select name="res_failure_causecode5" id="res_failure_causecode5" class="input-text validate-select" style="display: none;">
<option value="">- Select -</option>
<?php
    foreach($res_failure_causecode_arr5 as $v):
?>
<option value="<?php echo trim($v); ?>"<?php if($_SESSION['warranty_claim_data_preserve']['res_failure_causecode5'] == $v){?> selected="selected"<?php }?>><?php echo trim($v); ?></option>
<?php
    endforeach;
?>
</select>
&nbsp;<span class="mandatory_star_fields" style="float:left; margin-left:5px;">*</span></td>
</tr></table>
<br />
<table cellspacing="0" cellpadding="2" style="border: 1px solid #000 !important;" width="100%" border="1">
  <tr>
    <td colspan="6">&nbsp;</td>
   <!-- <td colspan="3" align="center" valign="top" class="warranty_block_class"><strong>Factory Use Only
</strong></td> -->
  </tr>
  <tr align="center" valign="top">
    <td colspan="2"><strong>Failed Part No. [?]
</strong></td>
    <td colspan="4"><strong>Description [?]
</strong></td>
<!--    <td width="28%"><strong>Replacement P / No.
</strong></td>
    <td width="7%"><strong>Approved
</strong></td>
    <td width="6%"><strong>Credit
</strong></td>
-->
  </tr>
  <tr>
    <td colspan="2"><input name="res_failure_failedpartno1" type="text" id="res_failure_failedpartno1" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_failedpartno1']; ?>" size="31" style="width:480px;" /></td>
    <td colspan="4"><input name="res_failure_failedpartdescr1" style="width:489px;" type="text" id="res_failure_failedpartdescr1" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_failedpartdescr1']; ?>" size="60" /></td>
<!--    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
-->
  </tr>
  <tr>
    <td colspan="2"><input name="res_failure_failedpartno2" type="text" id="res_failure_failedpartno2" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_failedpartno2']; ?>" size="31" style="width:480px;" /></td>
    <td colspan="4"><input name="res_failure_failedpartdescr2" style="width:489px;" type="text" id="res_failure_failedpartdescr2" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_failedpartdescr2']; ?>" size="60"  /></td>
<!--
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
 -->
  </tr>
  <tr>
    <td colspan="2"><input name="res_failure_failedpartno3" type="text" id="res_failure_failedpartno3" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_failedpartno3']; ?>" size="31" style="width:480px;" /></td>
    <td colspan="4"><input name="res_failure_failedpartdescr3" style="width:489px;" type="text" id="res_failure_failedpartdescr3" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_failedpartdescr3']; ?>" size="60" /></td>
 <!--   
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  -->
  </tr>
  <tr>
    <td width="166px" align="left" valign="top"><strong>Fan Motor Serial Number
</strong></td>
    <td width="280px"><input name="res_failure_srno1" type="text" id="res_failure_srno1" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_srno1']; ?>" size="54" /></td>
    <td width="183px" align="left" valign="top"><strong>Compressor Serial Number
</strong></td>
    <td width="4%"><input name="res_failure_compressor" type="text" id="res_failure_compressor" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_compressor']; ?>" size="55" /></td>
<!--    <td width="11%" align="center" valign="top"><strong>Serial Number
</strong></td>
    <td width="11%"><input name="res_failure_srno2" type="text" id="res_failure_srno2" value="<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_srno2']; ?>" size="10" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
-->  
  </tr>
  

</table> 


<br />
<div class="warranty_block_class"><strong>7. - Reason for Failure:</strong></div>
<br />
<table cellspacing="0" cellpadding="4" style="border: 1px solid #000 !important;" width="100%" border="1">        
  <tr>
    <td align="left" valign="top">
    <div>(Max. 250 characters)</div>
    <textarea name="reason_for_failure" rows="5" cols="133" onKeyDown="textCounter(this.form.reason_for_failure,this.form.remLen,250);" onKeyUp="textCounter(this.form.reason_for_failure,this.form.remLen,250);"><?php echo $_SESSION['warranty_claim_data_preserve']['reason_for_failure']; ?></textarea>
  <div><input readonly type="text" name="remLen" size="3" maxlength="3" value="250"> characters left</div>
    </td>
  </tr>  
  </table>
  
<br />

<div class="warranty_block_class"><strong>8. - Service Performed:</strong><span class="formInfo"><img height="18" width="18" alt="images3" src="<?php echo $this->getSkinUrl('js/js_tootip/images/question_img.jpg');?>" /><span style="display: none;" class="mycontent"><p>AC technician must provide specific test procedure used to determine the failed component.</p></span>
</span></div>
<br />
<table cellspacing="0" cellpadding="4" style="border: 1px solid #000 !important;" width="100%" border="1">
  <tr>
    <td align="left" valign="top">
    <div>(Max. 250 characters)</div>
    <textarea name="service_performed" rows="5" cols="133" onKeyDown="textCounter(this.form.service_performed,this.form.remLen1,250);" onKeyUp="textCounter(this.form.service_performed,this.form.remLen1,250);"><?php echo $_SESSION['warranty_claim_data_preserve']['service_performed']; ?></textarea>
    <div><input readonly type="text" name="remLen1" size="3" maxlength="3" value="250"> characters left</div>
    </td>
  </tr>
  
  </table>
<br />

<div class="warranty_block_class"><strong>9 - Extended Replacement Warranty (If applicable):</strong></div>
<br />
<table>
<!--
<tr><th><label for="extd_rplc_warranty_contractno" class="required">Contract No. :</label></th><td><input type="text" name="extd_rplc_warranty_contractno" id="extd_rplc_warranty_contractno" class="" value="<?php echo $_SESSION['warranty_claim_data_preserve']['extd_rplc_warranty_contractno']; ?>" /></td></tr>
-->
    <td align="left" valign="top" width="15"><input type="checkbox" name="extended_warranty" id="warrantytype_prod" value="1"<?php //if($_SESSION['warranty_claim_data_preserve']['productwarranty'] == 1){?> <?php //}?> /></td> <!-- checked="checked" -->
    <td align="left" valign="top"><strong><label for="extended_warranty" class="required">Did you purchase extended warranty ?</label></strong></td>


<!-- <tr><td colspan="8" align="center" valign="top"><div class="validation-advice" id="warrantytype_error_msg_id" style="display: none;">Please, select the Type of Warrranty: [Product | Parts | Extended | SLA]</div></td></tr>
-->
</table>
<br />
<!--
<table width="100%">
<tr><td class="warranty_block_class"><strong>9. - Factory Use Only</strong></td><td class="warranty_block_class"><strong>10. - Project Code / Special Authorization Code</strong></td></tr>
<tr>
<td width="50%" valign="top">
<table cellspacing="0" cellpadding="4" style="border: 1px solid #000 !important; height: 142px;" width="100%" border="1">
  <tr>
    <td align="left" valign="top">
-->    
    
    <!--<div>(Max. 250 characters)</div>
    <textarea name="factory_use_only" rows="5" cols="55" onKeyDown="textCounter(this.form.factory_use_only,this.form.remLen2,2000);" onKeyUp="textCounter(this.form.factory_use_only,this.form.remLen2,2000);"><?php echo $_SESSION['warranty_claim_data_preserve']['factory_use_only']; ?></textarea>
  <div><input readonly type="text" name="remLen2" size="3" maxlength="3" value="250"> characters left</div>-->
    </td>
  </tr>
  
  </table>
</td>

<td width="50%" valign="top">
<!-- <table cellspacing="0" cellpadding="4" style="border: 1px solid #000 !important; height: 142px;" width="100%" border="1">
  <tr>
    <td align="left" valign="top" style="color:#FF0000;">
-->
    <!--<textarea name="sp_auth_code" rows="5" cols="55" onKeyDown="textCounter(this.form.sp_auth_code,this.form.remLen3,250);" onKeyUp="textCounter(this.form.sp_auth_code,this.form.remLen3,250);"></textarea>-->
<?php
if($_SESSION['warranty_claim_succ_data_submit_flag']){
?>    
    <!--P1: Replacement part will be sent  free of charge &amp; customer<br>
pays S&amp;H. Please call 305-593-8358 to do necessary arrangements.<br>
P2: Warranty does not cover  your claim, you  may purchase the  replacement part &amp; pay for S&amp;H. Please call 305-593-8358 to do necessary arrangements.<br>
P3: You are authorized to purchase locally the failed part and  the moneys will be reimbursed. <br>
R1: Your unit will be replaced with a new one, you are obligated to pay S&amp;H. <br>
R2: Your unit will be replaced with a refurbished one, you are obligated to pay S&amp;H. Please call 305-593-8358 to do necessary arrangements.<br>
R3: Your extended warranty waves all charges,  S&amp;H will be paid by customer. Please call 305-593-8358 to do necessary arrangements.-->
<?php
  }
?>
<!-- 
    </td>
  </tr>  
</table>
-->
</td>
</tr>
</table>
<br />

<!--<div class="warranty_block_class"><strong>11. - Special Labor Allowance Amount*</strong><span class="formInfo"><img height="18" width="18" alt="images3" src="<?php echo $this->getSkinUrl('js/js_tootip/images/question_img.jpg');?>" /><span style="display: none;" class="mycontent"> -->
<!--
<table cellspacing="2" cellpadding="2" style="border: 1px solid #FFF !important;" width="100%" border="1">  


  <tr>
    <td width="15">L1</td>
    <td width="64">Minimum</td>
    <td align="right" width="68">$40.00 </td>
    <td width="64">Up to 30 min</td>
    <td width="64">Capacitor</td>
  </tr>
  <tr>
    <td>L2</td>
    <td>L1*2</td>
    <td align="right">$80.00 </td>
    <td>Up to 1 hr.</td>
    <td>Outdoor motor, fan blade,contactor,solenoid coil,sensor,synchronized    motor</td>
  </tr>
  <tr>
    <td>L3</td>
    <td>L1*3</td>
    <td align="right">$120.00 </td>
    <td>Up to 1.5 hr.</td>
    <td>Service valves,TXV,solenoid valve,indoor fan motor,switches</td>
  </tr>
  <tr>
    <td>L4</td>
    <td>L1*4</td>
    <td align="right">$160.00 </td>
    <td>Up to 2 hr.</td>
    <td>Reversing valve,blower wheel,PCB,ignition</td>
  </tr>
  <tr>
    <td>L5</td>
    <td>L1*5</td>
    <td align="right">$200.00 </td>
    <td>Up to 2.5 hr.</td>
    <td>Mini-split compressor,pumps,gas valves</td>
  </tr>
  <tr>
    <td>L6</td>
    <td>L1*6</td>
    <td align="right">$240.00 </td>
    <td>Up to 3.0 hr.</td>
    <td>Inverter compessor,central AC compressor,inverter PCB</td>
  </tr>
  <tr>
    <td>L7</td>
    <td>L1*7</td>
    <td align="right">$280.00 </td>
    <td colspan="2">Up to 4.0 hr.</td>
  </tr>
  <tr>
    <td>L8</td>
    <td>L1*8</td>
    <td align="right">$320.00 </td>
    <td>Up to 5.0 hr.</td>
    <td>Multi-split until compressors</td>
  </tr>
</table>


<br>

<table cellspacing="2" cellpadding="2" style="border: 1px solid #FFF !important;" width="100%" border="1">  
  <tr>
    <td width="10"></td>
    <td>L1:Klimaire will reimburse You $_ to    compensate the time allowance to make necessary repairs</td>
  </tr>
  <tr>
    <td></td>
    <td>L2:Klimaire will reimburse You $_ to compensate the time allowance to    make necessary repairs</td>
  </tr>
  <tr>
    <td></td>
    <td>L3:Klimaire will reimburse You $_ to compensate the time allowance to    make necessary repairs</td>
  </tr>
  <tr>
    <td></td>
    <td>L4:Klimaire will reimburse You $_ to compensate the time allowance to    make necessary repairs</td>
  </tr>
  <tr>
    <td></td>
    <td>L5:Klimaire will reimburse You $_ to compensate the time allowance to    make necessary repairs</td>
  </tr>
  <tr>
    <td></td>
    <td>L6:Klimaire will reimburse You $_ to compensate the time allowance to    make necessary repairs</td>
  </tr>
  <tr>
    <td></td>
    <td>L7:Klimaire will reimburse You $_ to compensate the time allowance to    make necessary repairs</td>
  </tr>
</table>

</span><br/>
</span></div>
<br />
-->
<!-- <table cellspacing="0" cellpadding="4" style="border: 1px solid #000 !important; height: 142px;" width="100%" border="1">
  
  <tr>
    <td align="left" valign="top">
 -->   <!--<div>(Max. 250 characters)</div>    
    <textarea name="sp_labour_allowance_amt" rows="5" cols="117" onKeyDown="textCounter(this.form.sp_labour_allowance_amt,this.form.remLen4,250);" onKeyUp="textCounter(this.form.sp_labour_allowance_amt,this.form.remLen4,250);"><?php echo $_SESSION['warranty_claim_data_preserve']['sp_labour_allowance_amt']; ?></textarea>
  <div><input readonly type="text" name="remLen4" size="3" maxlength="3" value="250"> characters left</div>-->
   <!-- </td>
  </tr>
  
</table>

<div>* To be processed by company</div>
-->
<br />

<table cellspacing="0" cellpadding="0">
<!--
  <tr>
    <td><u>Summay</u></td>
  </tr>
  <tr>
    <td>Your warranty claim has been processed and based on the information provided by you and on the Klimaire Warranty    Policy</td>
  </tr>
  <tr>
    <td>see below the results.</td>
  </tr>
  <tr>
    <td>1. Outcome from box number 5 will be displayed</td>
  </tr>
  <tr>
    <td>2. Outcome from box number 10 will be displayed</td>
  </tr>
  <tr>
    <td>3. Outcome from box number 11 will be displayed</td>
  </tr>
  <tr>
    <td>4. If there in not selection on boxes No. 5, 10,11 there wil be not display in this section for the corresponding box</td>
  </tr>
  <tr>
    <td height="10">&nbsp;</td>
  </tr>
  -->
  <tr>
    <td>To proceed with the above results pleaase contact your dealer where you purchased your unit or email us to warranty@klimaire.com, or call Klimaire customer service department at 305-593-8358. Make sure you have your claim number is included in your email or handy when calling.</td>
  </tr>
  <tr>
    <td height="10">&nbsp;</td>
  </tr>
  <?php
  if($_SESSION['warranty_claim_succ_data_submit_flag']){
  ?>
  <tr>
    <td style="color: #FF0000;">Upon completion the system will send to the customer, dispatch department, and accounting department</td>
  </tr>
  <tr>
    <td style="color: #FF0000;">an automated e-mail informing the resolution of the claim. The customer can view also the outcome of his claim in the    website.</td>
  </tr>
  <?php
  }
  ?>
</table>

<div align="center"><input type="submit" name="submit" value=" Submit " class="button-wattantyclim" onclick="warranty_custom_validation();" /><input type="reset" name="clear all" class="button-wattantyclim" value=" Clear all "></div>
</form>
<?php unset($_SESSION['warranty_claim_succ_data_submit_flag']); ?>
<script type="text/javascript">
//<![CDATA[
    var warranty_claim_Form = new VarienForm('warranty_claim_Form', true);
    //]]>
</script>
<script type="text/javascript">
var $jq = jQuery.noConflict();
$jq(document).ready(function() {
    // assuming the controls you want to attach the plugin to have the "datepicker" class set
    $jq('#prod_purchasedon').Zebra_DatePicker();
    $jq('#prod_serviceon').Zebra_DatePicker();    
    $jq('#prod_installedon').Zebra_DatePicker();
 });
</script>
<?php if(isset($_SESSION['warranty_claim_data_preserve']['res_failure_failedcompocode'])){?>
<script type="text/javascript">
Reason_of_Failure_data('<?php echo $_SESSION['warranty_claim_data_preserve']['res_failure_failedcompocode']; ?>');
</script>
<?php }?>


<?php
                
                /*
                    This shows how to load specific fields from a record in the database.
                    1) Note the load(15), this corresponds to saying "select * from table where table_id = 15"
                    2) You can then just use the get(fieldname) to pull specific data from the table.
                    3) If you have a field named news_id, then it becomes getNewsId, etc.
                */
                
                /*$news = Mage::getModel('warrantyclaim/warrantyclaim')->load(15);
                echo $news->getNewsId();
                echo $news->getTitle();
                echo $news->getContent();
                echo $news->getStatus();*/
                
                
                /*
                    This shows an alternate way of loading datas from a record using the database the "Magento Way" (using blocks and controller).
                     Uncomment blocks in /app/code/local/Namespace/Module/controllers/IndexController.php if you want to use it.

               */
                /*
                $object = $this->getWarrantyClaim();
                echo 'id: '.$object['test_id'].'<br/>';
                echo 'title: '.$object['title'].'<br/>';
                echo 'content: '.$object['content'].'<br/>';
                echo 'status: '.$object['status'].'<br/>';
                */            
            
            
                /*
                    This shows how to load multiple rows in a collection and save a change to them.
                    1) The setPageSize function will load only 5 records per page and you can set the current Page with the setCurPage function.
                    2) The $collection->walk('save') allows you to save everything in the collection after all changes have been made.
                */
                
                //$i = 0;
                
                //$collection = Mage::getModel('warrantyclaim/warrantyclaim')->getCollection();
                //$collection->setPageSize(5);
                //$collection->setCurPage(2);
                
                /*$size = $collection->getSize();
                $cnt = count($collection);
                foreach ($collection as $item) {
                    $i = $i+1;
                    $item->setTitle($i);
                    echo $item->getTitle();
                }*/

                //$collection->walk('save');
                
                
                /*
                    This shows how to load a single record and save a change.
                    1) Note the setTitle, this corresponds to the table field name, title, and then you pass it the text to change.
                    2) Call the save() function only on a single record.
                */
                /*
                $object = Mage::getModel('warrantyclaim/warrantyclaim')->load(1);
                $object->setTitle('This is a changed title');
                $object->save();
                */

?>
