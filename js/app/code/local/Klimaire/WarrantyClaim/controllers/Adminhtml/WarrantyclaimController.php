<?php

class Klimaire_WarrantyClaim_Adminhtml_WarrantyclaimController extends Mage_Adminhtml_Controller_action
{
 	const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';
	const EMAIL_TEMPLATE_XML_PATH = 'contacts/email/email_template';
	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('klimaire/warrantyclaim')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('warrantyclaim/warrantyclaim')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
		
			
			Mage::register('warrantyclaim_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('klimaire/warrantyclaim');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit'))
				->_addLeft($this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('warrantyclaim')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}

	public function sendmyEmail($message, $subject, $to, $toname, $from="warranty@klimaire.com", $fromname="Klimiare: Warranty Claim.")
	{
		$mail = Mage::getModel('core/email');
		$mail->setToName($toname);
		$mail->setToEmail($to);
		$mail->setBody($message);
		$mail->setSubject($subject);
		$mail->setFromEmail($from);
		$mail->setFromName($fromname);
		$mail->setType('html');// YOu can use Html or text as Mail format
		
		$mail2 = Mage::getModel('core/email');
		$mail2->setToName('Biren Zaverchand');
		$mail2->setToEmail('biren@sigmasolve.net');
		$mail2->setBody($message);
		$mail2->setSubject($subject);
		$mail2->setFromEmail($from);
		$mail2->setFromName($fromname);
		$mail2->setType('html');// YOu can use Html or text as Mail format
		
		$mail3 = Mage::getModel('core/email');
		$mail3->setToName('Virendra Jadeja');
		$mail3->setToEmail('vjadeja@sigmasolve.net');
		$mail3->setBody($message);
		$mail3->setSubject($subject);
		$mail3->setFromEmail($from);
		$mail3->setFromName($fromname);
		$mail3->setType('html');// YOu can use Html or text as Mail format
		
		try{
			$mail->send();
			$mail2->send();
			$mail3->send();
			return true;
			}
		catch (Exception $e) { return false;}
	}
		public function approveAction()
        {
			$post = $this->getRequest()->getPost();
			$msgbody='<html>
				<head>
				  <title>Klimaire: Warranty Claim Registration.</title>
				</head>
				<body>
				  <p><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/kilmair/default/images/logo.gif" /></p>
<div>Dear '.$post["reg_fname"].', '.$post["reg_lname"].' <br /><br />Please find the updated warranty claim information submitted by you </div><br /><br />
<div>Claim Status : <strong>Approved</strong>.</div><br /><br />
<div>You will be notified when your claim is processed and updated.</div><br /><br />
<div>Thank you,<br /><a href="http://www.klimaire.com" target="_blank" >Klimaire.com</a></div>
				</body>
				</html>';

			if($this->sendmyEmail($msgbody,'Kliamaire : Your claim status update.',$post['contact_email'],$post['reg_fname'].' '.$post['reg_lname']))
			{
           		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('warrantyclaim')->__('Warranty Claim - '.$this->getRequest()->getParam('id').' was successfully approved.'));
           		Mage::getSingleton('adminhtml/session')->setFormData(false);
			}
			else
			{
				Mage::getSingleton('core/session')->addError('There is problem in approval process.');
			}
           $this->_redirect('*/*/'); 
        }
		public function disapproveAction()
        {
			$post = $this->getRequest()->getPost();
			
			$model = Mage::getModel('warrantyclaim/warrantyclaim');		
			$model->setData($post)
				->setId($this->getRequest()->getParam('id'));
			$model->setStatus('2');	
			$model->save();
			$msgbody='<html>
				<head>
				  <title>Klimaire: Warranty Claim Registration.</title>
				</head>
				<body>
				  <p><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/kilmair/default/images/logo.gif" /></p>
<div>Dear '.$post["reg_fname"].', '.$post["reg_lname"].' <br /><br />Please find the updated warranty claim information submitted by you </div><br /><br />
<div>Claim ID : <strong>'.$this->getRequest()->getParam('id').'</strong>.</div><br /><br />
<div>Claim Status : <strong>Disapproved</strong>.</div><br /><br />
<div>Please contact klimaire customer service center for more detail.</div><br /><br />
<div>Thank you,<br /><a href="http://www.klimaire.com" target="_blank" >Klimaire.com</a></div>
				</body>
				</html>';

			if($this->sendmyEmail($msgbody,'Kliamaire : Your claim status update.',$post['contact_email'],$post['reg_fname'].' '.$post['reg_lname']))
			{
           		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('warrantyclaim')->__('Warranty Claim - '.$this->getRequest()->getParam('id').' was successfully disapproved.'));
           		Mage::getSingleton('adminhtml/session')->setFormData(false);
			}
			else
			{
				Mage::getSingleton('core/session')->addError('There is problem in disapproval process.');
			}
           $this->_redirect('*/*/'); 
           	 
        }
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
                    $post = $data;
					
					if(intval($post["res_failure_replacement_credit1"]) > 150 && trim($post["res_failure_replacement_credit1"]) != "")
					{
						Mage::getSingleton('adminhtml/session')->addError('Invalid Credit value for Part 1.');
						$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
						return;	
					}
					if(intval($post["res_failure_replacement_credit2"]) > 150 && trim($post["res_failure_replacement_credit2"]) != "")
					{
						Mage::getSingleton('adminhtml/session')->addError('Invalid Credit value for Part 2.');
						$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
						return;	
					}
					if(intval($post["res_failure_replacement_credit3"]) > 150 && trim($post["res_failure_replacement_credit3"]) != "")
					{
						Mage::getSingleton('adminhtml/session')->addError('Invalid Credit value for Part 3.');
						$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
						return;	
					}
					
		$message1 = '
				<html>
				<head>
				  <title>Klimaire: Warranty Claim Registration.</title>
				</head>
				<body>
				  <p><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/kilmair/default/images/logo.gif" /></p>
<div>Dear '.$post["reg_fname"].', '.$post["reg_lname"].' <br /><br />Please find the updated warranty claim information submitted by you </div><br /><br />
				<div><strong>1. - Registered Information:</strong></div>
				<br>
				<table width="100%" cellspacing="3" cellpadding="1" border="0">
				  <tbody>
				  <tr>
				    <th width="23%" valign="top" align="left"><label for="reg_code">Claim ID:</label></th>
				    <td width="16%"> ' . $this->getRequest()->getParam('id'). '				    
				    </td>

				  </tr>
				  <tr>
				    <th width="23%" valign="top" align="left"><label for="reg_code">Registration Code:</label></th>
				    <td width="16%"> ' .$post["confirmcode"]. '				    
				    </td>

				  </tr>
				  <tr>
				    <th width="23%" valign="top" align="left"><label for="reg_code">Product Code:</label></th>
				    <td width="16%"> ' . $post["prod_code"]. '				    
				    </td>

				  </tr>
				 
				  <tr><td valign="top" align="left" height="30" colspan="3">
				 
				  </td></tr>
				  
				  <tr>
				    <th width="23%" valign="top" align="left"><label for="reg_fname">Firstname:</label></th>
				    <td width="16%">' .$post["reg_fname"]. '</td>
				    
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="reg_lname">Lastname:</label></th>
				    <td>' .$post["reg_lname"]. '</td>
				    
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="reg_addr1">Address:</label></th>
				    <td>' .$post["reg_addr1"]. '</td>

				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="reg_addr2">Apt/Unit#:</label></th>
				    <td>' .$post["reg_addr2"]. '</td>
				    <td valign="top" align="left">&nbsp;<!--<span class="mandatory_star_fields">*</span>--></td>
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="reg_zip">Zip Code:</label></th>
				    <td>' .$post["reg_zip"]. '</td>
				    
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="reg_ph">Phone:</label></th>
				    <td>' .$post["reg_ph"]. '</td>
				    
				  </tr>  
				  <tr>
				    <th valign="top" align="left"><label for="reg_email">Email:</label></th>
				    <td>' .$post["reg_email"]. '</td>
				    
				  </tr>  

				  <tr>
				    <th valign="top" align="left"><label for="reg_email">Current Phone No:</label></th>
				    <td>' .$post["contact_ph"]. '</td>
				    
				  </tr> 
				  <tr>
				    <th valign="top" align="left"><label for="reg_email">Current Email:</label></th>
				    <td>' .$post["contact_email"]. '</td>
				    
				  </tr> 
				  <tr>
				    <th valign="top" align="left"><label for="reg_email">Current Address :</label></th>
				    <td>' .$post["contact_addr1"]. '</td>
				    
				  </tr> 
				  <tr>
				    <th valign="top" align="left"><label for="reg_email">Current Zip Code:</label></th>
				    <td>' .$post["contact_zip"]. '</td>
				    
				  </tr> 

				</tbody></table>
				<br>
				<div class="warranty_block_class"><strong>2. - Product Information:</strong></div>
				<br>
				<table width="100%" cellspacing="3" cellpadding="1" border="0">    
				  <tbody><tr>
				    <th valign="top" align="left"><label for="prod_code">Product Code:</label></th>
				    <td width="17%">' .$post["prod_code"]. '</td>
				    <td width="61%" valign="top" align="left">&nbsp;</td>
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="prod_srno">Serial Number:</label></th>
				    <td>' .$post["prod_srno"]. '</td>

				  </tr>  
				  <tr>
				    <th valign="top" align="left"><label for="prod_installedon">Date Installed:</label></th>
				    <td width="17%">' .$post["prod_installedon"]. ' </td>	

				  </tr>  
				  <tr>
				    <th valign="top" align="left"><label for="prod_serviceon">Service Date:</label></th>
				    <td width="17%">' .$post["prod_serviceon"]. ' </td>	

				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="prod_purchasedon">Purchase Date:</label></th>
				    <td width="17%">' .$post["prod_purchasedon"]. ' </td>
				  </tr>

				  
				 <tr>
				    <th valign="top" align="left"><label for="contact_zip">Zip Code:</label></th>
				    <td>' .$post["contact_zip"]. '</td>
				    
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="contact_ph">Phone:</label></th>
				    <td>' .$post["contact_ph"]. '</td>
				    
				  </tr>  
				  <tr>
				    <th valign="top" align="left"><label for="contact_email">Email:</label></th>
				    <td>' .$post["contact_email"]. '</td>
				    
				  </tr>  

  				  <tr>
				    <th valign="top" align="left"><label for="contact_addr1">Address:</label></th>
				    <td>' .$post["contact_addr1"]. '</td>

				  </tr>
				</tbody></table>  
				<br>

				<div><strong>3. - Servicing Contractor Information: </strong></div>
				<br>
				<table width="100%" cellspacing="1" cellpadding="1" border="0">
				  <tbody><tr align="left">
				    <th width="22%" valign="top" align="left"><label for="serv_contra_name">Servicing Contractor Name:</label></th>
				    <td width="10%">' .$post["serv_contra_name"]. '</td>
				    <td valign="top" align="left" colspan="4">&nbsp;</td>
				  </tr>
				  <tr align="left">
				    <th valign="top" align="left"><label for="serv_contra_addr">Contractor s Street Address:</label></th>
				    <td>' .$post["serv_contra_addr"]. '</td>
				    <td valign="top" align="left" colspan="4">&nbsp;</td>
				  </tr>
				  <tr align="left">
				    <th valign="top" align="left"><label for="serv_contra_city">City:</label></th>
				    <td width="25%">' .$post["serv_contra_city"]. '</td>
				    <th width="7%" valign="top" align="left"><label for="serv_contra_state">State:</label></th>
				    <td>' .$post["serv_contra_state"]. '</td>
				    <th width="5%" valign="top" align="left"><label for="serv_contra_zip">Zip:</label></th>
				    <td>' .$post["serv_contra_zip"]. '</td>
				  </tr>
				  <tr align="left">
				    <th valign="top" align="left"><label for="serv_contra_ph">Phone No.:</label></th>
				    <td>' .$post["serv_contra_ph"]. '</td>
				    <td valign="top" align="left" colspan="4">&nbsp;</td>
				  </tr>
				  <tr align="left">
				    <th valign="top" align="left"><label for="serv_contra_licenseno">Contractor s License Number:</label></th>
				    <td>' .$post["serv_contra_licenseno"]. '</td>


				    <td valign="top" align="left" colspan="4">&nbsp;</td>
				  </tr>  
				</tbody></table>
				<br>

				<div><strong>4. - Purchase from:</strong></div>
				<br>
				<table><tbody><tr align="left"><th><label for="purchasefrom_loc">Purchase from:</label></th><td>' .$post["purchasefrom_loc"]. '</td><br/><th><label for="purchasefrom_ph">Phone No. :</label></th><td>' .$post["purchasefrom_ph"]. '</td></tr></tbody></table>
				<br>

				<div><strong>5. - Reason of Failure (Select from the window / table):</strong></div>
				<br>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
				<th valign="top"><label for="res_failure_failedcompocode">Failed component code:</label></th>
				<td>' .$post["res_failure_failedcompocode"]. '</td>
				<th valign="top"><label for="res_failure_compocode">Component code:</label></th>
				<td>' .$post["res_failure_compocode"]. '</td>
				<th valign="top"><label for="res_failure_causecode">Cause code:</label></th>
				<td>' .$post["res_failure_causecode"]. '</td>
				</tr></tbody></table>
				<br>
				<table width="100%" cellspacing="0" cellpadding="2" border="1" style="border: 1px solid #000 !important;">
				  <tbody>
				  <tr valign="top" align="center">
				    <td colspan="5"><strong>Failed Part No. 
				</strong></td>
				    <td colspan="7"><strong>Description 
				</strong></td>
				 
				  </tr> 
			';
			if(isset($post["res_failure_failedpartno1"])){
				$message1 .= '
				  <tr align="left">  <td colspan="5">' .$post["res_failure_failedpartno1"]. '</td>
				    <td colspan="7">' .$post["res_failure_failedpartdescr1"]. '</td>
				  </tr>
				  ';}if(isset($post["res_failure_failedpartno2"])){
				  	$message1 .= '
				  <tr align="left">
				    <td colspan="5">' .$post["res_failure_failedpartno2"]. '</td>
				    <td colspan="7">' .$post["res_failure_failedpartdescr2"]. '</td>
				  </tr>
				   ';}if(isset($post["res_failure_failedpartno3"])){
				  	$message1 .= '
				  <tr align="left">
				    <td colspan="5">' .$post["res_failure_failedpartno3"]. '</td>
				    <td colspan="7">' .$post["res_failure_failedpartdescr3"]. '</td>
				  </tr>
				  ';}
				  $message1 .= '
				  <tr align="left">
				    <td colspan="2"  valign="top" align="center"><strong>Fan Motor Serial Number
				</strong></td>
				    <td colspan="3" >' .$post["res_failure_srno1"]. '</td>
				   
				    <td colspan="2" valign="top" align="center"><strong>Compressor Serial Number
				</strong></td>
				    <td colspan="3">' .$post["res_failure_compressor"]. '</td>
				    
				  </tr> 	
				  ';
				  $message1 .= '
				</tbody></table> 
				<div>
				<ul>';
				if(isset($post["res_failure_failedpartno1"]) && trim($post["res_failure_failedpartno1"]) != '')
				{
					$approveamtmsg='';
					if($post["res_failure_replacement_approval1"]=="1")
					{
						$msgpart1 = "Your unit is covered by Klimaire Limited Warranty, so please contact your dealer to proceed. The Replacement Part # is: ". $post["res_failure_replacement_pno1"];
						$approveamtmsg="You are authorized to buy locally the part in the amount of ".$post["res_failure_replacement_credit1"];
					}
					if($post["res_failure_replacement_approval1"]=="0")
					{
						$msgpart1 = "Your unit is not under Klimaire Limited Warranty, so please make necessary approach to obtain the necessary part to repair your unit.";
					}		
					$message1 .= "<li>". $post['res_failure_failedpartno1']. " : ".$msgpart1."</li>";
					if($approveamtmsg != '')
					{	$message1 .= "<li>" .$post['res_failure_failedpartno1']. " : ".$approveamtmsg."</li>";}	
					

				}
				//for second part
				if(isset($post["res_failure_failedpartno2"]) && trim($post["res_failure_failedpartno2"]) != '')
				{
					$approveamtmsg='';
					if($post["res_failure_replacement_approval2"]=="1")
					{
						$msgpart1 = "Your unit is covered by Klimaire Limited Warranty, so please contact your dealer to proceed. The Replacement Part # is: ". $post["res_failure_replacement_pno2"];
						$approveamtmsg="You are authorized to buy locally the part in the amount of ".$post["res_failure_replacement_credit2"];
					}
					if($post["res_failure_replacement_approval2"]=="0")
					{
						$msgpart1 = "Your unit is not under Klimaire Limited Warranty, so please make necessary approach to obtain the necessary part to repair your unit.";
					}		
					$message1 .= '<li >' .$post["res_failure_failedpartno2"]. ' : '.$msgpart1.'</li>';
					if($approveamtmsg != '')
					{	$message1 .= '<li >' .$post["res_failure_failedpartno2"]. ' : '.$msgpart1.'</li>';}	
				}
				//for third part
				if(isset($post["res_failure_failedpartno3"]) && trim($post["res_failure_failedpartno3"]) != '')
				{
					$approveamtmsg='';
					if($post["res_failure_replacement_approval3"]=="1")
					{
						$msgpart1 = "Your unit is covered by Klimaire Limited Warranty, so please contact your dealer to proceed. The Replacement Part # is: ". $post["res_failure_replacement_pno3"];
						$approveamtmsg="You are authorized to buy locally the part in the amount of ".$post["res_failure_replacement_credit3"];
					}
					if($post["res_failure_replacement_approval3"]=="0")
					{
						$msgpart1 = "Your unit is not under Klimaire Limited Warranty, so please make necessary approach to obtain the necessary part to repair your unit.";
					}		
					$message1 .= '<li>' .$post["res_failure_failedpartno3"]. ' : '.$msgpart1.'</li>';
					if($approveamtmsg != '')
					{	$message1 .= '<li >' .$post["res_failure_failedpartno3"]. ' : '.$msgpart1.'</li>';}	
				}
				$message1 .= '</ul>
				</div>

				<br>
				<div class="warranty_block_class"><strong>6. - Reason for Failure:</strong></div>
				<br>
				<table width="100%" cellspacing="0" cellpadding="4">        
				  <tbody><tr>
				    <td valign="top" align="left">' .$post["reason_for_failure"]. '</td>
				  </tr>  
				  </tbody></table>
				  
				<br>

				<div class="warranty_block_class"><strong>7. - Service Performed:</strong></div>
				<br>
				<table width="100%" cellspacing="0" cellpadding="4" >
				  <tbody><tr align="left">
				    <td valign="top" align="left">' .$post["service_performed"]. ' </td>
				  </tr>
				  
				  </tbody></table>
				<br>

				<div><strong>8 - Extended Replacement Warranty (If applicable):</strong></div>
				<br>
				
				
				';
				if($post["extended_warranty"]==1){
					$message1 .= 'Yes <br /><br />Invoice No./Extended Warranty Contract No.:'.$post["extendedwarrantybillnumber"];
					}else{
						$message1 .= 'No';
						}			
				$message1 .= '</span></div><br /><br />
				<div>Your warranty claim has been processed and based on the information provided by you and on the Klimaire Warranty Policy see below the results.</div>
				<br />
				<div><strong>Special Authorization:</strong> <span >'.$post["sp_auth_code"].'</span></div>
				<br />
				<div><strong>Special Labour Allowance:</strong><span >'.$post["sp_labour_allowance_amt"].'</span></div>
				<div><br />To proceed with the above results pleaase contact your dealer where you purchased your unit or email us to warranty@klimaire.com, or call Klimaire customer service department at 305-593-8358. Make sure you have your claim number is included in your email or handy when calling.</div>
				</body>
				</html>
				';

		$warrantytype_arr = array('productwarranty','partswarranty','extendedwarranty','slawarranty');
		foreach($warrantytype_arr as $v){
			if(!in_array($v,array_keys($data))){
				$data[$v] = 0;
			}
		}
		
		
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}	
	  			
			$model = Mage::getModel('warrantyclaim/warrantyclaim');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('warrantyclaim')->__('Warranty Claim data was successfully saved.'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
                                
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				
$mail1 = Mage::getModel('core/email');		 
$mail1->setToName($post['reg_fname'].' '.$post['reg_lname']);
$mail1->setToEmail($post['contact_email']);
$mail1->setBody($message1);
$mail1->setSubject('Klimiare: Warranty Claim Id - '.$this->getRequest()->getParam('id'));
$mail1->setFromEmail('warranty@klimaire.com');
$mail1->setFromName("Klimiare: Warranty Claim.");
$mail1->setType('html');// YOu can use Html or text as Mail format
// Dispatch Department
$mail2 = Mage::getModel('core/email');
$mail2->setToName('Carlos');
$mail2->setToEmail('carlos@klimaire.com');
$mail2->setBody($message1);
$mail2->setSubject('Klimiare: Warranty Claim Id - '.$this->getRequest()->getParam('id'));
$mail2->setFromEmail('warranty@klimaire.com');
$mail2->setFromName("Klimiare: Warranty Claim.");
$mail2->setType('html');// YOu can use Html or text as Mail format
//
//Dispatch Department
$mail3 = Mage::getModel('core/email');
$mail3->setToName('Yammir');
$mail3->setToEmail('yammir@klimaire.com');
$mail3->setBody($message1);
$mail3->setSubject('Klimiare: Warranty Claim Id - '.$this->getRequest()->getParam('id'));
$mail3->setFromEmail('warranty@klimaire.com');
$mail3->setFromName("Klimiare: Warranty Claim.");
$mail3->setType('html');// YOu can use Html or text as Mail format
//
//Dispatch Department
$mail4 = Mage::getModel('core/email');
$mail4->setToName('Nathan');
$mail4->setToEmail('nathan@klimaire.com');
$mail4->setBody($message1);
$mail4->setSubject('Klimiare: Warranty Claim Id - '.$this->getRequest()->getParam('id'));
$mail4->setFromEmail('warranty@klimaire.com');
$mail4->setFromName("Klimiare: Warranty Claim.");
$mail4->setType('html');// YOu can use Html or text as Mail format
//
//Accounting Department
$mail5 = Mage::getModel('core/email');
$mail5->setToName('Alexis');
$mail5->setToEmail('alexis@klimaire.com');
$mail5->setBody($message1);
$mail5->setSubject('Klimiare: Warranty Claim Id - '.$this->getRequest()->getParam('id'));
$mail5->setFromEmail('warranty@klimaire.com');
$mail5->setFromName("Klimiare: Warranty Claim.");
$mail5->setType('html');// YOu can use Html or text as Mail format
//
//Accounting Department
$mail6 = Mage::getModel('core/email');
$mail6->setToName('Marvin');
$mail6->setToEmail('marvin@klimaire.com');
$mail6->setBody($message1);
$mail6->setSubject('Klimiare: Warranty Claim Id - '.$this->getRequest()->getParam('id'));
$mail6->setFromEmail('warranty@klimaire.com');
$mail6->setFromName("Klimiare: Warranty Claim.");
$mail6->setType('html');// YOu can use Html or text as Mail format
//
//
$mail7 = Mage::getModel('core/email');
$mail7->setToName('Biren');
$mail7->setToEmail('biren@sigmasolve.net');
$mail7->setBody($message1);
$mail7->setSubject('Klimiare: Warranty Claim Id - '.$this->getRequest()->getParam('id'));
$mail7->setFromEmail('Warranty@klimaire.com');
$mail7->setFromName("Klimiare: Warranty Claim.");
$mail7->setType('html');// YOu can use Html or text as Mail format
//
//
$mail8 = Mage::getModel('core/email');
$mail8->setToName('Virendra');
$mail8->setToEmail('vjadeja@sigmasolve.net');
$mail8->setBody($message1);
$mail8->setSubject('Klimiare: Warranty Claim Id - '.$this->getRequest()->getParam('id'));
$mail8->setFromEmail('Warranty@klimaire.com');
$mail8->setFromName("Klimiare: Warranty Claim.");
$mail8->setType('html');// YOu can use Html or text as Mail format
//

try {
$mail1->send();
$mail8->send();
$mail7->send();
$mail6->send();
$mail5->send();
$mail4->send();
$mail3->send();
$mail2->send();
Mage::getSingleton('core/session')->addSuccess('Your request has been sent');

}
catch (Exception $e) {
//Mage::getSingleton('core/session')->addError('Unable to send.');
//$this->_redirect('*/*/');
}
              
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        //Mage::getSingleton('adminhtml/session')->addError(Mage::helper('warrantyclaim')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('warrantyclaim/warrantyclaim');
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Warranty Claim data was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $warrantyclaimIds = $this->getRequest()->getParam('warrantyclaim');
        if(!is_array($warrantyclaimIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($warrantyclaimIds as $warrantyclaimId) {
                    $warrantyclaim = Mage::getModel('warrantyclaim/warrantyclaim')->load($warrantyclaimId);
                    $warrantyclaim->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($warrantyclaimIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $warrantyclaimIds = $this->getRequest()->getParam('warrantyclaim');
        if(!is_array($warrantyclaimIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($warrantyclaimIds as $warrantyclaimId) {
                    $warrantyclaim = Mage::getSingleton('warrantyclaim/warrantyclaim')
                        ->load($warrantyclaimId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($warrantyclaimIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'warrantyclaim.csv';
        $content    = $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'warrantyclaim.xml';
        $content    = $this->getLayout()->createBlock('warrantyclaim/adminhtml_warrantyclaim_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}