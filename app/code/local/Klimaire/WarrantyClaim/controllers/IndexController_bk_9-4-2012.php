<?php
class Klimaire_WarrantyClaim_IndexController extends Mage_Core_Controller_Front_Action
{
    const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';
	
    public function indexAction(){
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/warrantyclaim?id=15 
    	 *  or
    	 * http://site.com/warrantyclaim/id/15 	
    	 */
    	/* 
		$warrantyclaim_id = $this->getRequest()->getParam('id');

  		if($warrantyclaim_id != null && $warrantyclaim_id != '')	{
			$warrantyclaim = Mage::getModel('warrantyclaim/warrantyclaim')->load($warrantyclaim_id)->getData();
		} else {
			$warrantyclaim = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($warrantyclaim == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$warrantyclaimTable = $resource->getTableName('warrantyclaim');
			
			$select = $read->select()
			   ->from($warrantyclaimTable,array('warrantyclaim_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$warrantyclaim = $read->fetchRow($select);
		}
		Mage::register('warrantyclaim', $warrantyclaim);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }

    public function getRegCodeArr(){			
			$warrantyregprod = Mage::getModel('warrantyregprod/warrantyregprod');
			$chk_confirmcode_coll_obj = $warrantyregprod->getCollection();
			$chk_confirmcode_coll_tmparr = array();
			foreach($chk_confirmcode_coll_obj as $obj)
			{
				$chk_confirmcode_coll_tmparr[] = $obj->getConfirmcode();	
			}
			
			if(is_array($chk_confirmcode_coll_tmparr) && count($chk_confirmcode_coll_tmparr) > 0)
			return $chk_confirmcode_coll_tmparr;
			else
			return false;
	}

    public function checkClaimRegistrationByRegCode($regCode){			
			$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
			$_qur = "select '(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.prodcode)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = warrantyregprod.warrantyregprod_id) as prodcode' from warrantyregprod inner join warrantyclaim on warrantyregprod.confirmcode = warrantyclaim.confirmcode where warrantyclaim.confirmcode = '".$regCode."'";
			$_res = $read_handler->query($_qur);
			$_rows = $_res->fetchAll();
			
			if(count($_rows) > 0)
			{
				return false;				
			}			
			else
			{
				return true;
			}			
	}

    public function checkProdCodeByRegCode($prodCode,$regCode){			
			$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
			$_qur = "select t2.prodcode,t2.indr_prodcode from warrantyregprod as t1 inner join warrantyregprodchild as t2 on t1.warrantyregprod_id	 = t2.warrantyregprodID where t1.confirmcode = '".$regCode."'";
			$_res = $read_handler->query($_qur);
			$_rows = $_res->fetchAll();
			$returnFlag = false;
			foreach($_rows as $obj)
			{
				if($prodCode == $obj['prodcode'] || $prodCode == $obj['indr_prodcode'])
				{
					$returnFlag = true;
					break;
				}
			}
			return $returnFlag;
	}
	
    public function postAction(){

		$post = $this->getRequest()->getPost();
		//echo '<pre>'; print_r($post); exit;
        if ($post) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;
				$error_cnt = 0;

			
				$notCheck_arr = array('zip','phno','srno','warrantytype','reason_for_failure','service_performed','factory_use_only','sp_auth_code','sp_labour_allowance_amt','extd_rplc_warranty_contractno','reg_addr2','res_failure_failedpartno1','res_failure_failedpartno2','res_failure_failedpartno3','res_failure_failedpartdescr1','res_failure_failedpartdescr2','res_failure_failedpartdescr3','res_failure_srno1','res_failure_srno2','res_failure_compressor','res_failure_compocode','res_failure_compocode1','res_failure_compocode2','res_failure_compocode3','res_failure_compocode4','res_failure_compocode5','res_failure_causecode','res_failure_causecode1','res_failure_causecode2','res_failure_causecode3','res_failure_causecode4','res_failure_causecode5');
				
				
				
				//$form_label_to_name_mapping_arr = array('zip'=>'Zip Code','phno'=>'Phone No','srno'=>'Serial No');
				if($post['contact_pt_radio'] != '')
				{
					switch($post['contact_pt_radio'])
					{
						case 'zip':
							$contact_pt_radio_data_arr = array('zip');
						break;
	
						case 'phno':
							$contact_pt_radio_data_arr = array('phno');					
						break;
						
						case 'srno':
							$contact_pt_radio_data_arr = array('srno');
						break;										
					}
				}
				else
				{
					Mage::getSingleton('core/session')->addError("Please, select any of contact entity [Zip Code/Phone No./Serial No.]");	
					
				}
				
				$form_label_to_name_mapping_arr = array('reg_code'=>'Registration Code','reg_fname'=>'Firstname','reg_lname'=>'Lastname','reg_addr1'=>'Address1','reg_addr2'=>'Address2','reg_zip'=>'Zip Code','reg_ph'=>'Phone','reg_email'=>'Email','prod_code'=>'Product Code','prod_srno'=>'Serial Number','prod_installedon'=>'Date Installed','prod_serviceon'=>'Service Date','prod_purchasedon'=>'Purchase Date','serv_contra_name'=>'Servicing Contractor Name','serv_contra_addr'=>"Contractor's Street Address",'serv_contra_city'=>'City','serv_contra_state'=>'State','serv_contra_zip'=>'Zip','serv_contra_ph'=>'Phone No','serv_contra_licenseno'=>"Contractor's License Number",'purchasefrom_loc'=>'Purchase from','purchasefrom_ph'=>'Phone No','res_failure_failedcompocode'=>'Failed component code','extd_rplc_warranty_contractno'=>'Contract No');  //'res_failure_compocode'=>'Component code','res_failure_causecode'=>'Cause code'
		
		//var_dump($post['res_failure_compocode1']); exit;
				
				foreach(array_keys($post) as $post_key)
				{					
					if (!in_array($post_key,$notCheck_arr) && !Zend_Validate::is(trim($post[$post_key]) , 'NotEmpty')) {
						$error = true;
						if($error_cnt == 0)
						{
							Mage::getSingleton('core/session')->addError("Followings are required. Please, input the data.");	
						}
						$error_cnt++;
						Mage::getSingleton('core/session')->addError('-&nbsp;'.$form_label_to_name_mapping_arr[$post_key]);
					}								
				}
				
				/*if(!isset($post['warrantytype']))
				{
					$error_cnt++;
					Mage::getSingleton('core/session')->addError("Please, select the warranty type.");	
				}
				else
				{
					$post['warrantytype'] = implode(',',$post['warrantytype']);
				}*/				

				if($post['reg_code'] != '')
				{										
					$chk_confirmcode_coll_tmparr = $this->getRegCodeArr();
					if(!is_bool($chk_confirmcode_coll_tmparr))
					{
						if(!in_array($post['reg_code'],$chk_confirmcode_coll_tmparr))
						{
							$error_cnt++;
							Mage::getSingleton('core/session')->addError("Registration code does not exist.");
						}
						else
						{							
							if(!$this->checkProdCodeByRegCode($post['prod_code'],$post['reg_code']))
							{
								$error_cnt++;
								Mage::getSingleton('core/session')->addError("You are attempting for the wrong Product code.<br />Please, select the applicable Product code.");
							}
							else if(!$this->checkClaimRegistrationByRegCode($post['reg_code']))
							{
								$error_cnt++;
								Mage::getSingleton('core/session')->addError("The Claim already registered with the Registration code : ".$post['reg_code']."<br />Kindly, contact to service provider.");	
							}
						}
					}
				}

				// for data preserve in front end form
				$_SESSION['warranty_claim_data_preserve'] = $post;
				// for data preserve in front end form
				
				if($error_cnt > 0)
				{
					$this->_redirect('*/*/');
					return;				
				}
				
				//var_dump($error);
                if ($error) {
                    throw new Exception();
                }
				
				
                /*$mailTemplate = Mage::getModel('core/email_template');*/
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                /*$mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                        null,
                        array('data' => $postObject)
                    );*/
				//var_dump($mailTemplate->getSentSuccess()); 
                /*if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }*/

                //$translate->setTranslateInline(true);
				
				/*$createNewPostAction_Return = $this->createNewPostAction($post);
				if(!$createNewPostAction_Return){
                    throw new Exception();					
				}
				

                Mage::getSingleton('core/session')->addSuccess('Your claim has been submitted and will be responded to as soon as possible.<br />Thank you for registration');
				unset($_SESSION['warranty_claim_data_preserve']);
				$_SESSION['warranty_claim_succ_data_submit_flag'] = true;*/
                //$this->_redirect('*/*/');
                //return;				

				$this->_redirect('warrantyclaim-preview/');
				return;
								

            } catch (Exception $e) {
                $translate->setTranslateInline(true);
				//var_dump($e); exit;
                Mage::getSingleton('core/session')->addError('Unable to submit your claim submission request. Please, try again later');
				//echo 'Unable to submit your request. Please, try again later';
                $this->_redirect('*/*/');
                return;
            }

        } else {
            $this->_redirect('*/*/');
        }
    }

    public function warrantymanagerpostAction()
    {
		try
		{
						
		$warrantyclaim = Mage::getModel('warrantyclaim/warrantyclaim');
		$data = $this->getRequest()->getPost();	
		/*foreach($data as $data_key => $data_val)
		{		
		$pos = strpos($data_key, 'hidden_');
		if ($pos === false) {
				$dataFinal[$data_key] = $data_val;			
		}
		}		
		foreach($data as $data_key => $data_val)
		{
			$data_key = ucfirst($data_key);
			$methodName = "set".$data_key;
			$warrantyclaim->$methodName(trim($data_val));
		}*/
		//echo '<pre>'; print_r($data); $warrantyclaim->setData($data)->setId($data['hidden_claim_id']); var_dump($warrantyclaim->save()); exit;
		//$warrantyclaim->setData($data)->setId($data['hidden_claim_id']);
		$warrantyclaim->load($data['hidden_claim_id'])->addData($data);		
			if(!$warrantyclaim->setId($data['hidden_claim_id'])->save())
			{
			   throw new Exception();					
			}

	    } 
		catch (Exception $e) 
		{				
             Mage::getSingleton('core/session')->addError('Unable to submit your claim submission request. Please, try again later');
             $this->_redirect('*/*/');
             return;
		}				
	
			//var_dump($warrantyclaim->getSelect()->printLogQuery(true, true)); exit;
			$notApprovedData = '';
			for($i=1; $i<=3; $i++)
			{	
				if(isset($data['hidden_res_failure_failedpartno'.$i]) && !isset($data['res_failure_replacement_approval'.$i]))
				{
					$notApprovedData .= html_entity_decode($data['hidden_res_failure_failedpartno'.$i]).'<br /><br />';
				}
			}

			if($notApprovedData != '')
			{
				// multiple recipients
				$to  = $data['hidden_reg_email'];

				// subject
				$subject = 'Klimaire: Warranty Claim Disapproval.';

				// message
				$message = '
				<html>
				<head>
				  <title>Klimaire: Warranty Claim Disapproval.</title>
				</head>
				<body>
				  <p><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/kilmair/default/images/logo.gif" /></p>
				  <p>Unfortunately your claim for the followings have Not been approved:</p>				  
				  <p>Confirmation Code:&nbsp;'.$data['hidden_confirmcode'].'</p>
				  <p>'.$notApprovedData.'</p>
				  <p>If you have any query, email us to warranty@klimaire.com, or call Klimaire customer service department
at 305-593-8358. Make sure you have your claim number is included in your email or handy when calling.</p>
				</body>
				</html>
				';

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: '.ucfirst($data['hidden_reg_fname']).' '.ucfirst($data['hidden_reg_lname']).' <'.$data['hidden_reg_email'].'>' . "\r\n";
				$headers .= 'From: Klimiare: Warranty Claim Disapproval. <'.Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER).'>' . "\r\n";
				//$headers .= 'Cc: a@a.com' . "\r\n";
				//$headers .= 'Bcc: s@a.com' . "\r\n";

				// Mail it
				mail($to, $subject, $message, $headers);
			}


			 Mage::getSingleton('core/session')->addSuccess('Claim has been updated successfully...');
             $this->_redirect('warrantymanager/');
             return;		

	}

    public function confirmedpostAction(){
		try
		{

		$post = $_SESSION['warranty_claim_data_preserve'];
		$createNewPostAction_Return = $this->createNewPostAction($post);
				if(!$createNewPostAction_Return){
                    throw new Exception();					
				}
				//var_dump($post['reg_lname']); echo '<pre>'; print_r($post); exit;

				// multiple recipients
				$to  = $post['reg_email'];
				//$to1  = "Warranty@Klimare.com";
				$to1  = "Warranty@Klimare.com";
				// subject
				$subject = 'Klimaire: Warranty Claim Registration.';
				$subject1 = 'Klimaire: Warranty Claim Registration.';
if($post["zip"] != ""){ $zipdisplay = $post["zip"]; }else { $zipdisplay = "NA"; }
if($post["phno"] != ""){ $phnodisplay = $post["phno"]; }else { $phnodisplay = "NA"; }
if($post["srno"] != ""){ $srnodisplay = $post["srno"]; }else { $srnodisplay = "NA"; }
				// message
				$message = '
				<html>
				<head>
				  <title>Klimaire: Warranty Claim Registration.</title>
				</head>
				<body>
				  <p><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/kilmair/default/images/logo.gif" /></p>
				  <p>Your claim has been submitted and will be responded to as soon as possible.</p>				  
				  <p>Thank you for registration.</p>
				</body>
				</html>
				';
				//mail body for admin
				$message1 = '
				<html>
				<head>
				  <title>Klimaire: Warranty Claim Registration.</title>
				</head>
				<body>
				  <p><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/kilmair/default/images/logo.gif" /></p>

				<div><strong>1. - Registered Information:</strong></div>
				<br>
				<table width="100%" cellspacing="3" cellpadding="1" border="0">
				  <tbody><tr>
				    <th width="23%" valign="top" align="right"><label for="reg_code">Registration Code:</label></th>
				    <td width="16%"> ' .$post["reg_code"]. '				    
				    </td>

				  </tr>
				  
				  <tr><td valign="top" align="left" height="30" colspan="3">
				  <div style="position:absolute;margin:0 0 0 112px;">
				<table width="100%" cellspacing="1" cellpadding="1" border="0" align="center">
				  <tbody><tr> 
				    <td width="85" valign="top" align="left"><strong><label for="zip_radio">Zip Code:</label></strong></td>
				    <td valign="top" align="left"> ' .$zipdisplay. '</td>


				    <td width="103" valign="top" align="left"><strong><label for="phno_radio">Phone No.:</label></strong></td>
				    <td valign="top" align="left">' .$phnodisplay. '</td>
				    <td width="85" valign="top" align="left"><strong><label for="srno_radio">Serial No.:</label></strong></td>
				    <td valign="top" align="left">' .$srnodisplay. '</td>    
				  </tr>
				  <tr><td valign="top" align="left" colspan="9">
				  </td></tr>
				</tbody></table>  
				  </div>
				  </td></tr>
				  
				  <tr>
				    <th width="23%" valign="top" align="right"><label for="reg_fname">Firstname:</label></th>
				    <td width="16%">' .$post["reg_fname"]. '</td>
				    
				  </tr>
				  <tr>
				    <th valign="top" align="right"><label for="reg_lname">Lastname:</label></th>
				    <td>' .$post["reg_lname"]. '</td>
				    
				  </tr>
				  <tr>
				    <th valign="top" align="right"><label for="reg_addr1">Address:</label></th>
				    <td>' .$post["reg_addr1"]. '</td>

				  </tr>
				  <tr>
				    <th valign="top" align="right"><label for="reg_addr2">Apt/Unit#:</label></th>
				    <td>' .$post["reg_addr2"]. '</td>
				    <td valign="top" align="left">&nbsp;<!--<span class="mandatory_star_fields">*</span>--></td>
				  </tr>
				  <tr>
				    <th valign="top" align="right"><label for="reg_zip">Zip Code:</label></th>
				    <td>' .$post["reg_zip"]. '</td>
				    
				  </tr>
				  <tr>
				    <th valign="top" align="right"><label for="reg_ph">Phone:</label></th>
				    <td>' .$post["reg_ph"]. '</td>
				    
				  </tr>  
				  <tr>
				    <th valign="top" align="right"><label for="reg_email">Email:</label></th>
				    <td>' .$post["reg_email"]. '</td>
				    
				  </tr>  
				</tbody></table>
				<br>
				<div class="warranty_block_class"><strong>2. - Product Information:</strong></div>
				<br>
				<table width="100%" cellspacing="3" cellpadding="1" border="0">    
				  <tbody><tr>
				    <th valign="top" align="right"><label for="prod_code">Product Code:</label></th>
				    <td width="17%">' .$post["prod_code"]. '</td>
				    <td width="61%" valign="top" align="left">&nbsp;</td>
				  </tr>
				  <tr>
				    <th valign="top" align="right"><label for="prod_srno">Serial Number:</label></th>
				    <td>' .$post["prod_srno"]. '</td>

				  </tr>  
				  <tr>
				    <th valign="top" align="right"><label for="prod_installedon">Date Installed:</label></th>
				    <td width="17%">' .$post["prod_installedon"]. ' </td>	

				  </tr>  
				  <tr>
				    <th valign="top" align="right"><label for="prod_serviceon">Service Date:</label></th>
				    <td width="17%">' .$post["prod_serviceon"]. ' </td>	

				  </tr>
				  <tr>
				    <th valign="top" align="right"><label for="prod_purchasedon">Purchase Date:</label></th>
				    <td width="17%">' .$post["prod_purchasedon"]. ' </td>	


				  </tr>    
				</tbody></table>  
				<br>

				<div><strong>3. - Servicing Contractor Information: </strong></div>
				<br>
				<table width="100%" cellspacing="1" cellpadding="1" border="0">
				  <tbody><tr>
				    <th width="22%" valign="top" align="left"><label for="serv_contra_name">Servicing Contractor Name:</label></th>
				    <td width="10%">' .$post["serv_contra_name"]. '</td>
				    <td valign="top" align="left" colspan="4">&nbsp;</td>
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="serv_contra_addr">Contractor s Street Address:</label></th>
				    <td>' .$post["serv_contra_addr"]. '</td>
				    <td valign="top" align="left" colspan="4">&nbsp;</td>
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="serv_contra_city">City:</label></th>
				    <td width="25%">' .$post["serv_contra_city"]. '</td>
				    <th width="7%" valign="top" align="left"><label for="serv_contra_state">State:</label></th>
				    <td>' .$post["serv_contra_state"]. '</td>
				    <th width="5%" valign="top" align="left"><label for="serv_contra_zip">Zip:</label></th>
				    <td>' .$post["serv_contra_zip"]. '</td>
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="serv_contra_ph">Phone No.:</label></th>
				    <td>' .$post["serv_contra_ph"]. '</td>
				    <td valign="top" align="left" colspan="4">&nbsp;</td>
				  </tr>
				  <tr>
				    <th valign="top" align="left"><label for="serv_contra_licenseno">Contractor s License Number:</label></th>
				    <td>' .$post["serv_contra_licenseno"]. '</td>
				    <td valign="top" align="left" colspan="4">&nbsp;</td>
				  </tr>  
				</tbody></table>
				<br>

				<div><strong>4. - Purchase from:</strong></div>
				<br>
				<table><tbody><tr><th><label for="purchasefrom_loc">Purchase from:</label></th><td>' .$post["purchasefrom_loc"]. '</td><br/><th><label for="purchasefrom_ph">Phone No. :</label></th><td>' .$post["purchasefrom_ph"]. '</td></tr></tbody></table>
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
				  <tbody><tr>
				    <td colspan="6">&nbsp;</td>
				<strong>Factory Use Only
				</strong>
				  </tr>
				  <tr valign="top" align="center">
				    <td colspan="2"><strong>Failed Part No. 
				</strong></td>
				    <td colspan="4"><strong>Description 
				</strong></td>
				  </tr>
				  <tr>
				    <td colspan="2">' .$post["res_failure_failedpartno1"]. '</td>
				    <td colspan="4">' .$post["res_failure_failedpartdescr1"]. '</td>
				    
				  </tr>
				  <tr>
				    <td colspan="2">' .$post["res_failure_failedpartno2"]. '</td>
				    <td colspan="4">' .$post["res_failure_failedpartdescr2"]. '</td>
				    
				  </tr>
				  <tr>
				    <td colspan="2">' .$post["res_failure_failedpartno3"]. '</td>
				    <td colspan="4">' .$post["res_failure_failedpartdescr3"]. '</td>
				    
				  </tr>
				  <tr>
				    <td width="11%" valign="top" align="center"><strong>Serial Number
				</strong></td>
				    <td width="9%">' .$post["res_failure_srno1"]. '</td>
				    <td width="10%" valign="top" align="center"><strong>Compressor
				</strong></td>
				    <td width="7%">' .$post["res_failure_compressor"]. '</td>
				    <td width="11%" valign="top" align="center"><strong>Serial Number
				</strong></td>
				    <td width="11%">' .$post["res_failure_srno2"]. '</td>
				    
				  </tr>
				</tbody></table> 


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
				  <tbody><tr>
				    <td valign="top" align="left">' .$post["service_performed"]. ' </td>
				  </tr>
				  
				  </tbody></table>
				<br>

				<div><strong>8 - Extended Replacement Warranty (If applicable):</strong></div>
				<br>
				<table><tbody><tr><th><label for="extd_rplc_warranty_contractno">Contract No. :</label></th><td>' .$post["extd_rplc_warranty_contractno"]. '</td></tr></tbody></table>
				</span></div>





				</body>
				</html>
				';
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: '.ucfirst($post['reg_fname']).' '.ucfirst($post['reg_lname']).' <'.$post['reg_email'].'>' . "\r\n";
				$headers .= 'From: Klimiare: Warranty Claim Registration. <'.Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER).'>' . "\r\n";



				//$headers .= 'Cc: a@a.com' . "\r\n";
				//$headers .= 'Bcc: s@a.com' . "\r\n";

// To send HTML mail, the Content-type header must be set
				$headers1  = 'MIME-Version: 1.0' . "\r\n";
				$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers1 .= 'To: Klimaiare Admin <Warranty@Klimare.com>' . "\r\n";
				$headers1 .= 'From: Klimiare. <'.Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER).'>' . "\r\n";

				// Mail it
				mail($to, $subject, $message, $headers);
				mail($to1, $subject1, $message1, $headers1);


                Mage::getSingleton('core/session')->addSuccess('Your claim has been submitted and will be responded to as soon as possible.<br />Thank you for registration');
				unset($_SESSION['warranty_claim_data_preserve']);
				$_SESSION['warranty_claim_succ_data_submit_flag'] = true;
                $this->_redirect('*/*/');
                return;	
				
				
		 } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('core/session')->addError('Unable to submit your claim submission request. Please, try again later');
				//echo 'Unable to submit your request. Please, try again later';
                $this->_redirect('*/*/');
                return;
         }
										
	}
	
    // ********* //// Save/Insert the posted Data to Model "warrantyclaim". //// *********
    public function createNewPostAction($data) {
		$warrantyclaim = Mage::getModel('warrantyclaim/warrantyclaim');
		//echo '<pre>'; print_r($data); exit;			
		// Setting Up the data to model to save them in db.
		foreach($data as $data_key => $data_val)
		{
			
			//$component_code_index_arr = array('res_failure_compocode1','res_failure_compocode2','res_failure_compocode3','res_failure_compocode4','res_failure_compocode5');			
			//$cause_code_index_arr = array('res_failure_causecode1','res_failure_causecode2','res_failure_causecode3','res_failure_causecode4','res_failure_causecode5');
			
			if($data_key != 'reg_code')
			{
				$data_key = ucfirst($data_key);
				$methodName = "set".$data_key;
				$warrantyclaim->$methodName(trim($data_val));
			}
			else
			{
				$warrantyclaim->setConfirmcode(trim($data_val));
			}
		}

		switch($data['res_failure_failedcompocode'])
		{
			case 'Refrigerant System':
				$warrantyclaim->setRes_failure_compocode($data['res_failure_compocode1']);
				$warrantyclaim->setRes_failure_causecode($data['res_failure_causecode1']);
			break;
			
			case 'Compressor / Motors':
				$warrantyclaim->setRes_failure_compocode($data['res_failure_compocode2']);
				$warrantyclaim->setRes_failure_causecode($data['res_failure_causecode2']);
			break;
			
			case 'Electrical Components':
				$warrantyclaim->setRes_failure_compocode($data['res_failure_compocode3']);
				$warrantyclaim->setRes_failure_causecode($data['res_failure_causecode3']);
			break;
			
			case 'Non-Electrical Components':
				$warrantyclaim->setRes_failure_compocode($data['res_failure_compocode4']);
				$warrantyclaim->setRes_failure_causecode($data['res_failure_causecode4']);
			break;
			
			case 'Gas Furnace / Boiler':
				$warrantyclaim->setRes_failure_compocode($data['res_failure_compocode5']);
				$warrantyclaim->setRes_failure_causecode($data['res_failure_causecode5']);
			break;                    
		}
		

		if(isset($contact_pt_radio_data_arr) && count($contact_pt_radio_data_arr) > 0)
		{
			$methodName = "set".ucfirst($contact_pt_radio_data_arr['0']);
			$warrantyclaim->$methodName($data[$contact_pt_radio_data_arr['0']]);
		}
		
		$warrantyclaim->setCreated_time(date('Y-m-d H:i:s'));
		$warrantyclaim->setStatus('1');
		
		// Setting Up the data to model to save them in db.
			
		if($warrantyclaim->save())
		return true;//true;
		else
		return false;
	}
	
    // ********* //// Save/Insert the posted Data to Model "warrantyregprod". //// *********
    public function fillformbyserialnumberAction(){
        $srcode = $_REQUEST['sr_code'];
        $read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
	$_qur = "select fname,lname,addr1,apt,email,zipcode,phno from warrantyregprod,warrantyregprodchild where warrantyregprod.warrantyregprod_id = warrantyregprodchild.warrantyregprodID and warrantyregprodchild.serialno = '".$srcode."'";
        $_qur2= "select prodcode from warrantyregprod,warrantyregprodchild where warrantyregprod.warrantyregprod_id = warrantyregprodchild.warrantyregprodID AND warrantyregprodchild.serialno='".$srcode."'";
	$_res = $read_handler->query($_qur);
	$_row = $_res->fetchAll();
	if(count($_row) > 0)
	{
            foreach($_row as $data)
            {
		$data_arr[] = $data['fname'];
		$data_arr[] = $data['lname'];
		$data_arr[] = $data['addr1'];						
		$data_arr[] = $data['apt'];						
		$data_arr[] = $data['zipcode'];
		$data_arr[] = $data['phno'];
		$data_arr[] = $data['email'];																		
		
            }
	}
        $_res2 = $read_handler->query($_qur2);
	$_row2 = $_res2->fetchAll();
        if(count($_row2) > 0)
	{
            foreach($_row2 as $data2)
            {
                $data_arr[] = $data2['prodcode'];
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data_arr));
    }
    public function fillformbyregistrationcodeAction(){
        $rcode = $_REQUEST['reg_code'];
        $read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
	$_qur = "select fname,lname,addr1,apt,email,zipcode,phno from warrantyregprod where confirmcode = '".$rcode."'";
        $_qur2= "select prodcode from warrantyregprod,warrantyregprodchild where warrantyregprod.warrantyregprod_id = warrantyregprodchild.warrantyregprodID AND warrantyregprod.confirmcode='".$rcode."'";
	$_res = $read_handler->query($_qur);
	$_row = $_res->fetchAll();
	if(count($_row) > 0)
	{
            foreach($_row as $data)
            {
		$data_arr[] = $data['fname'];
		$data_arr[] = $data['lname'];
		$data_arr[] = $data['addr1'];						
		$data_arr[] = $data['apt'];						
		$data_arr[] = $data['zipcode'];
		$data_arr[] = $data['phno'];
		$data_arr[] = $data['email'];																		
		
            }
	}
        $_res2 = $read_handler->query($_qur2);
	$_row2 = $_res2->fetchAll();
        if(count($_row2) > 0)
	{
            foreach($_row2 as $data2)
            {
                $data_arr[] = $data2['prodcode'];
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data_arr));
    }
    public function ajaxAction(){
        //$result["error"] = 0;
		$data_arr[0] = 'false';
		$chk_confirmcode_coll_tmparr = $this->getRegCodeArr();
		if(!is_bool($chk_confirmcode_coll_tmparr))
		{
			if(!in_array($this->getRequest()->getPost('reg_code'),$chk_confirmcode_coll_tmparr))
			{
		        $data_arr[0] = 'true';
				//$result["error"] = 1;
			}
			else
			{
				$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
				$_qur = "select fname,lname,addr1,apt,email,zipcode,phno from warrantyregprod where confirmcode = '".$this->getRequest()->getPost('reg_code')."'";
				$_res = $read_handler->query($_qur);
				$_row = $_res->fetchAll();
				if(count($_row) > 0)
				{
					foreach($_row as $data)
					{
						$data_arr[] = $data['fname'];
						$data_arr[] = $data['lname'];
						$data_arr[] = $data['addr1'];						
						$data_arr[] = $data['apt'];						
						$data_arr[] = $data['zipcode'];
						$data_arr[] = $data['phno'];
						$data_arr[] = $data['email'];																		
						//$err .= '_'.$data_arr;
					}
				}
			
			}
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data_arr));
		//$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}
		
    public function warrantylookupAction(){
		    if ($this->getRequest()->IsPost()) {
			$post = $this->getRequest()->getPost();					
			$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
	
			if(isset($post['reg_code']) && $post['reg_code'] != '')
			{
				//$read_handler_warrantyregprod_query = 'SELECT t1.warrantyregprod_id,t1.created_time,t1.installedon,t1.dealername, (select warrantyregprodchild.warr_type from warrantyregprodchild, warrantyregprod where warrantyregprodchild.warrantyregprodID=warrantyregprod.warrantyregprod_id and warrantyregprod.warrantyregprod_id=t1.warrantyregprod_id) as warr_type,(select catalog_product_flat_1.short_description from catalog_product_flat_1 where upper(catalog_product_flat_1.name) = ( select warrantyregprodchild.prodcode FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id)) as short_description, (select warrantyregprodchild.prodtype from warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as indr_prodtype,(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.prodcode)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as prodcode,(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.serialno)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as serialno,(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.indr_prodcode)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as indr_prodcode,(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.indr_userialno)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as indr_userialno FROM warrantyregprod as t1 where t1.confirmcode = "'.trim($post['reg_code']).'"';
				$read_handler_warrantyregprod_query = 'SELECT t1.warrantyregprod_id, t1.created_time, t1.installedon, t1.dealername, wrpc.warr_type AS warr_type, cpf1.short_description AS short_description, wrpc.prodtype AS indr_prodtype, wrpc.prodcode AS prodcode, wrpc.serialno AS serialno, wrpc.indr_prodcode AS indr_prodcode, wrpc.indr_userialno indr_userialno FROM warrantyregprod AS t1 INNER JOIN warrantyregprodchild wrpc ON wrpc.warrantyregprodID = t1.warrantyregprod_id INNER JOIN catalog_product_flat_1 cpf1 ON cpf1.name = wrpc.prodcode WHERE t1.confirmcode = "'.trim($post['reg_code']).'"';
				//echo $read_handler_warrantyregprod_query;
				$read_handler_warrantyregprod_result = $read_handler->fetchAll($read_handler_warrantyregprod_query);
				//echo '<pre>'; print_r($read_handler_warrantyregprod_result); //exit;
				
				
				$read_handler_warrantyclaim_query = 'SELECT warrantyclaim_id, warrantytype, prod_code, prod_srno FROM warrantyclaim where confirmcode = "'.trim($post['reg_code']).'"';
								
				//echo $read_handler_warrantyclaim_query;
				$read_handler_warrantyclaim_result = $read_handler->fetchAll($read_handler_warrantyclaim_query);
				///echo '<pre>'; print_r($read_handler_warrantyclaim_result); exit;	
				
				/* added by viredra*/
				$_SESSION['warranty_lookup_prod_result_arr'] = Mage::helper('core')->jsonEncode($read_handler_warrantyregprod_result);
				//$_SESSION['warranty_lookup_claim_result_arr'] = Mage::helper('core')->jsonEncode($read_handler_warrantyclaim_result);
				$_SESSION['warranty_lookup_result_data_reserve'] = $post;
				
			}
			else
			{
				// Warranty Registred Product.
				//$read_handler_warrantyregprod_query = 'SELECT t1.warrantyregprod_id, t1.created_time, t1.installedon, t1.dealername,(select warrantyregprodchild.warr_type from warrantyregprodchild, warrantyregprod where warrantyregprodchild.warrantyregprodID=warrantyregprod.warrantyregprod_id and warrantyregprod.warrantyregprod_id=t1.warrantyregprod_id) as warr_type,(select catalog_product_flat_1.short_description from catalog_product_flat_1 where upper(catalog_product_flat_1.name) = ( select warrantyregprodchild.prodcode FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id)) as short_description, (select warrantyregprodchild.prodtype from warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as indr_prodtype,(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.prodcode)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as prodcode,(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.serialno)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as serialno,(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.indr_prodcode)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as indr_prodcode,(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.indr_userialno)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = t1.warrantyregprod_id) as indr_userialno FROM warrantyregprod as t1';
				$read_handler_warrantyregprod_query = 'SELECT t1.warrantyregprod_id, t1.created_time, t1.installedon, t1.dealername, wrpc.warr_type AS warr_type, cpf1.short_description AS short_description, wrpc.prodtype AS indr_prodtype, wrpc.prodcode AS prodcode, wrpc.serialno AS serialno, wrpc.indr_prodcode AS indr_prodcode, wrpc.indr_userialno indr_userialno FROM warrantyregprod AS t1 INNER JOIN warrantyregprodchild wrpc ON wrpc.warrantyregprodID = t1.warrantyregprod_id INNER JOIN catalog_product_flat_1 cpf1 ON cpf1.name = wrpc.prodcode ';
                                
                                
				if(isset($post['fname']) && $post['fname'] != '')
				$read_handler_warrantyregprod_query_arr[] = 'fname like "'.$post['fname'].'%"';

				if(isset($post['lname']) && $post['lname'] != '')
				$read_handler_warrantyregprod_query_arr[] = 'lname like "'.$post['lname'].'%"';
				
				if(isset($post['srno']) && $post['srno'] != '')
				$read_handler_warrantyregprod_query_arr[] = 'serialno like "'.$post['srno'].'"';
				
				if(isset($post['zipcode']) && $post['zipcode'] != '')
				$read_handler_warrantyregprod_query_arr[] = 'zipcode like "'.$post['zipcode'].'"';

				if(isset($post['phno']) && $post['phno'] != '')
				$read_handler_warrantyregprod_query_arr[] = 'phno like "'.$post['phno'].'"';
				
				if(is_array($read_handler_warrantyregprod_query_arr) && count($read_handler_warrantyregprod_query_arr) > 0)
				$read_handler_warrantyregprod_query_str = ' where '.implode(' or ',$read_handler_warrantyregprod_query_arr);
				
				$read_handler_warrantyregprod_query .= $read_handler_warrantyregprod_query_str;
				
				//echo $read_handler_warrantyregprod_query;
				$read_handler_warrantyregprod_result = $read_handler->fetchAll($read_handler_warrantyregprod_query);
				//echo '<pre>'; print_r($read_handler_warrantyregprod_result); //exit;

				// Warranty Claim Data.
				/*
				$read_handler_warrantyclaim_query = 'SELECT warrantyclaim_id, warrantytype, prod_code, prod_srno FROM warrantyclaim';
				
				if(isset($post['fname']) && $post['fname'] != '')
				$read_handler_warrantyclaim_query_arr[] = 'reg_fname like "'.$post['fname'].'%"';

				if(isset($post['lname']) && $post['lname'] != '')
				$read_handler_warrantyclaim_query_arr[] = 'reg_lname like "'.$post['lname'].'%"';
				
				if(isset($post['srno']) && $post['srno'] != '')
				$read_handler_warrantyclaim_query_arr[] = 'prod_srno like "'.$post['srno'].'"';
				
				if(isset($post['zipcode']) && $post['zipcode'] != '')
				$read_handler_warrantyclaim_query_arr[] = 'reg_zip like "'.$post['zipcode'].'"';

				if(isset($post['phno']) && $post['phno'] != '')
				$read_handler_warrantyclaim_query_arr[] = 'reg_ph like "'.$post['phno'].'"';
				
				if(is_array($read_handler_warrantyclaim_query_arr) && count($read_handler_warrantyclaim_query_arr) > 0)
				$read_handler_warrantyclaim_query_str = ' where '.implode(' or ',$read_handler_warrantyclaim_query_arr);
				
				$read_handler_warrantyclaim_query .= $read_handler_warrantyclaim_query_str;
								
				//echo $read_handler_warrantyclaim_query;
				$read_handler_warrantyclaim_result = $read_handler->fetchAll($read_handler_warrantyclaim_query);
				///echo '<pre>'; print_r($read_handler_warrantyclaim_result); exit;				
				*/
			}
			
			$_SESSION['warranty_lookup_prod_result_arr'] = Mage::helper('core')->jsonEncode($read_handler_warrantyregprod_result);
			//$_SESSION['warranty_lookup_claim_result_arr'] = Mage::helper('core')->jsonEncode($read_handler_warrantyclaim_result);
			$_SESSION['warranty_lookup_result_data_reserve'] = $post;

		
		//echo '<pre>'; print_r($this->getRequest()->getParams()); exit;
        $this->_redirect('warranty-lookup/');
        return;
		
		}
		else if($this->getRequest()->getParam('hidden_reset_flg') == 'set')
		{
				unset($_SESSION['warranty_lookup_prod_result_arr']);	
				unset($_SESSION['warranty_lookup_claim_result_arr']);	
				unset($_SESSION['warranty_lookup_result_arr']);
				//$_SESSION['warranty_lookup_result_arr']=0;
				/*echo "<script type='text/javascript'>alert(".$_SESSION['warranty_lookup_result_arr'].")</script>";*/
				unset($_SESSION['warranty_lookup_result_data_reserve']);
				//$_SESSION['warranty_lookup_result_data_reserve']=0;
				/*echo "<script type='text/javascript'>alert(".$_SESSION['warranty_lookup_result_data_reserve'].")</script>";*/
				$this->_redirect('warranty-lookup/');
				return;
		}
	}
}
