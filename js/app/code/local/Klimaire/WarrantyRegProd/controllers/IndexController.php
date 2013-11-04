<?php
class Klimaire_WarrantyRegProd_IndexController extends Mage_Core_Controller_Front_Action
{
    const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';
	
    public function indexAction(){
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function postAction(){
        if ($this->getRequest()->IsPost()) {
                        
            $post = $this->getRequest()->getPost();
            if ($post) {
			
             // for data preserve in front end form
             if($post['ask_for_more'] == 1)
                $_SESSION['warranty_reg_prod_data_reserve'] = $post;
             else if(isset($_SESSION['warranty_reg_prod_data_reserve']))
                unset($_SESSION['warranty_reg_prod_data_reserve']);
                           
             $_SESSION['warranty_reg_prod_data_reserve']=$post;
                                			
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;
				$notCheck_arr = array('apt','State','prodtype','dealer_phno','inst_zip','indoor_prodcode_0','indr_userialno_0','indoor_prodcode_1','indr_userialno_1','indoor_prodcode_2','indr_userialno_2','indoor_prodcode_3','indr_userialno_3','indoor_prodcode_4','indr_userialno_4','indoor_prodcode_5','indr_userialno_5','indoor_prodcode_6','indr_userialno_6','indoor_prodcode_7','indr_userialno_7','indoor_prodcode_8','indr_userialno_8','indoor_prodcode_9','indr_userialno_9');
				$form_label_to_name_mapping_arr = array('Firstname'=>'fname','Lastname'=>'lname','Address1'=>'addr1','Apt/Unit#'=>'apt','Email'=>'email','City'=>'city','State'=>'State','Zip Code'=>'zipcode','Phone'=>'phno','Product Type'=>'prodtype_0','Product Code'=>'prodcode_0','Serial Number'=>'serialno_0','Product Code'=>'prodcode_1','Serial Number'=>'serialno_1','Product Code'=>'prodcode_2','Serial Number'=>'serialno_2','Product Code'=>'prodcode_3','Serial Number'=>'serialno_3','Product Code'=>'prodcode_4','Serial Number'=>'serialno_4','Product Code'=>'prodcode_5','Serial Number'=>'serialno_5','Product Code'=>'prodcode_6','Serial Number'=>'serialno_6','Product Code'=>'prodcode_7','Serial Number'=>'serialno_7','Product Code'=>'prodcode_8','Serial Number'=>'serialno_8','Product Code'=>'prodcode_9','Serial Number'=>'serialno_9','Invoice Number'=>'invoiceno','Date Purchased'=>'purchasedon','Date Installed'=>'installedon','Dealer Name'=>'dealername','Installer Dealer Name'=>'inst_dealername','Installer License Number'=>'inst_licenseno','Installer Dealer Street Address'=>'inst_dealer_street','Installer Phone Number'=>'inst_dealer_ph','Dealer Phone Number'=>'dealer_phno','Installer City'=>'inst_city','State'=>'inst_state','Zip'=>'inst_zip','Installer Dealer Phone Number'=>'inst_dealer_phno');
				$error_cnt = 0;				
				$form_label_to_name_mapping_arr = array_flip($form_label_to_name_mapping_arr);
				foreach(array_keys($post) as $post_key)
				{					
					if (!in_array($post_key,$notCheck_arr) && !Zend_Validate::is(trim($post[$post_key]) , 'NotEmpty')) {
						$error = true;
						
						
                                                if($form_label_to_name_mapping_arr[$post_key] != '')
                                                {
                                             		  if($error_cnt == 0)
													{
													Mage::getSingleton('core/session')->addError("Followings are required. Please, input the data.");	
													}
                                                       Mage::getSingleton('core/session')->addError('-&nbsp;'.$form_label_to_name_mapping_arr[$post_key]);
                                                }
												$error_cnt++;
						
					}								
				}
                               
                               // var_dump($error_cnt);
									 //  exit;
                                //validation for matching models and category
                                for($i=0;$i<10;$i++)
                                {
                                    if(isset($post['product_type_cat_'.$i]))
                                    {
                                $category = Mage::getModel("catalog/category")->load($post['product_type_cat_'.$i]);
                                //21-yes,22-no
                               	 //var_dump($post['product_type_cat_'.$i]);
								// var_dump($category);
								 //exit;
                              /*  if($category['matching_model_and_serial'] == '21')
                                {
									//var_dump($post);
                                    if($post['indr_userialno_'.$i] == '')
                                    { 
                                        $error_cnt++;
                                        Mage::getSingleton('core/session')->addError('-&nbsp;'.'Please Provide Matching Unit Serial Number');
                                    }
                                    else
                                    {        
									
									///
									 $product = Mage::getModel('catalog/product')->load($post['prodcode_'.$i]);
                                     $serila_numbers = $product['klimaire_serial_numbers'];
                                     $sns = explode(",", $serila_numbers);
                                     $key = in_array($post['serialno_'.$i], $sns);
                                    
                                     if($key == false )
                                     {
                                        $error_cnt++;
					Mage::getSingleton('core/session')->addError('-&nbsp;'.'Invalid Serial Number');
                                     }
                                     else
                                     {
                                        $read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
                                        $_qur = "select serialno from warrantyregprodchild";
                                        $_res = $read_handler->query($_qur);
                                        $_rows = $_res->fetchAll();
                                        $used_sns= array();
                                        foreach($_rows as $v)
                                        {
                                            $used_sns[] = trim($v['serialno']); 
                                        }
                                        $key2 = in_array($post['serialno_'.$i], $used_sns);
                                        //var_dump($key2);
                                        //exit;
                                        if($key2 == true )
                                        {
                                            $error_cnt++;
                                            Mage::getSingleton('core/session')->addError('-&nbsp;'.'Serial number already used. Please provide valid Number');
                                        }
                                     }
									
									////
									                
                                       	$product1 = Mage::getModel('catalog/product')->load($post['indoor_prodcode_'.$i]);
                                        $serila_numbers1 = $product1['klimaire_serial_numbers'];
										$sns1 = explode(",", $serila_numbers1);
										
                                        $key1 = in_array($post['indr_userialno_'.$i], $sns1);
										
                                        if($key1 == false)
                                        {
                                            $error_cnt++;
                                            Mage::getSingleton('core/session')->addError('-&nbsp;'.'Invalid Matching Unit Serial Number');
                                        }
                                        else
                                        {
											//var_dump($sns1);
											//var_dump($post);
                                           $read_handler1 = Mage::getSingleton('core/resource')->getConnection('core_read');
                                            $_qur1 = "select serialno from warrantyregprodchild";
                                            $_res1 = $read_handler1->query($_qur1);
                                            $_rows1 = $_res1->fetchAll();
                                            $used_sns1= array();
                                                foreach($_rows1 as $v1)
                                                {
                                                        $used_sns1[] = trim($v1['serialno']); 
                                                }
												var_dump($used_sns1);
												//exit;
                                            $key21 = in_array($post['indoor_prodcode_'.$i], $used_sns1);
                                                if($key21 == true )
                                                {
                                                        $error_cnt++;
                                                        Mage::getSingleton('core/session')->addError('-&nbsp;'.'Matching Unit Serial Number already used. Please provide valid Number');
                                                }
												
                                        } 
                                    }
                                }
                                else {*/
                                     $product = Mage::getModel('catalog/product')->load($post['prodcode_'.$i]);
                                     $serila_numbers = $product['klimaire_serial_numbers'];
                                     $sns = explode(",", $serila_numbers);
                                     $key = in_array($post['serialno_'.$i], $sns);
                                    
                                     if($key == false )
                                     {
									 
                                       $error_cnt++;
									   
					Mage::getSingleton('core/session')->addError('-&nbsp;'.'Invalid Serial Number');
                                     }
                                     else
                                     {
                                        $read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
                                        $_qur = "select serialno from warrantyregprodchild";
                                        $_res = $read_handler->query($_qur);
                                        $_rows = $_res->fetchAll();
                                        $used_sns= array();
                                        foreach($_rows as $v)
                                        {
                                            $used_sns[] = trim($v['serialno']); 
                                        }
                                        $key2 = in_array($post['serialno_'.$i], $used_sns);
                                        
                                        if($key2 == true )
                                        {
                                            $error_cnt++;
											
                                            Mage::getSingleton('core/session')->addError('-&nbsp;'.'Serial number already used. Please provide valid Number');
                                        }
                                     }
                                    //}
                                  }
                                }
                                //end validation for matching models and category
						//echo $error_cnt;
						//exit;						
				if($error_cnt > 0)
				{
					Mage::getSingleton('core/session')->addError('-&nbsp;'.'Internal Server Error. Please try again after sometime.');
					$this->_redirect('*/*/');
					return;				
				}
				
				
                if ($error) {
                    throw new Exception();
                }
				
				$createNewPostAction_Return = $this->createNewPostAction($post);
                                
				if(!$createNewPostAction_Return){
                    throw new Exception();					
				}
				

				$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
				$last_Or_Max_ID = $read_handler->query('select max(warrantyregprod_id) as max_id from warrantyregprod')->fetchAll();
				
				//echo $this->getRequest()->getPost('hidden_product_info_cnt'),',',$last_Or_Max_ID[0]['max_id']; exit;
				/* decide warranty type*/
				
				$read_handler1 = Mage::getSingleton('core/resource')->getConnection('core_read');
				$_qur12 = "select DATEDIFF( CURDATE(),created_at)as gap from sales_flat_invoice where increment_id ='".$_SESSION['warranty_reg_prod_data_reserve']['invoiceno']."'";
				
				$ddif = $read_handler1->fetchOne($_qur12);
                     
					 /*echo $_qur12."<".$ddif.">";
					 print_r($ddif);
					 exit;*/
					 
				$wtype="";
				if((int)$ddif < 75)
				{
					// get product type by its drop value
					
					 $productval = Mage::getModel('catalog/product')->load($this->getRequest()->getPost('prodcode_0'));
                       $productname = $productval->getName();
					   
					   $warrantytypeID = explode(',',$productval['warrantytype']);	
					   
					   //for matching unit model
					   $testproductid=$post['indoor_prodcode_0'];
					   /*print_r($testproductid);
					   print_r($post);
					   exit;*/
					   if($testproductid != "")
					   {
					   $productval2 = Mage::getModel('catalog/product')->load($this->getRequest()->getPost('indr_userialno_0'));
                       $productname2 = $productval2->getName();
					   
					   $warrantytypeID2 = explode(',',$productval2['warrantytype']);
					   //merge both warranty id array
					   $newwtypeids = array_merge($warrantytypeID,$warrantytypeID2);
					   //remove duplicate ids.
					   $warrantytypeID = array_unique($newwtypeids);
					   }
					   			 	
					//
					//var_dump($warrantytypeID);
					 //  exit;
					
					//$_qur22 = "SELECT value as prod_type FROM eav_attribute_option_value WHERE option_id IN ( SELECT value FROM catalog_product_entity_int WHERE ( CONVERT( entity_id USING utf8 ) = (select entity_id from catalog_product_flat_1 where name='".$productname."') AND attribute_id =141 ) ) AND store_id = 1";
					//var_dump($_qur22);
					//exit;
					//$ptype = $read_handler1->fetchRow($_qur22);
					//prod type = "Condensing units", "Central Air conditioning Products" , "Maxwell Electric water heater Products"
					//$message =$_qur22;
					
					//$prod_type=$ptype['prod_type'];
						$prod_type="Condensing units";
						//$message.="<br/>2".$prod_type;
					$product_type= $this->getRequest()->getPost('prodtype_0');
					//$message.="<br/>3".$product_type;
					$_qur11="";
					/////
					$product = Mage::getModel('catalog/product');
					$productId = $product->getIdBySku( $this->getRequest()->getPost('prodcode_0') );
					$product->load($productId);

					//$product = Mage::getModel("catalog/product")->load(178);
    				$i = 1;
    				foreach ($product->getOptions() as $o) {
    				// Getting Values if it has option values, case of select,dropdown,radio,multiselect
 
        			$values = $o->getValues();
        			foreach ($values as $v) {
 							$d=$v->getData();
        					if($d['title']=='3 Years Warranty')
							{
								$ext_warr=$d['title'];	
							}
						}
 
        				$i++;
					}
					/////
					/*
					9	3 year replacement - No hassle
					10	3 year limited parts
					11	5 year commercial use
					12	1/3 commercial use
					13	10 year heat exchanger
					14	5 year compressor
					
					26 	residential:1 year All parts Base Warranty
					27	residential:5 year  Compressor Warranty
					28	commercial:1 year All parts Base Warranty
					29	commercial:3 year  Compressor Warranty
					30	residential:10 Year  Heat Exchanger Warranty
					31	commercial:5 Year  Heat Exchanger Warranty
					32	residential:3 Year Replacement
					33	residential:3 Year limited parts Warranty
					34	commercial:3 Year Replacement
					35	commercial:3 Year limited parts Warranty
					
					
					*/
					///		
					/*			
					if($product_type == 'commercial' && $prod_type == 'Condensing units')
					{
						if(in_array('14',$warrantytypeID))
						{
							$wtype .= ':5 year compressor';
						}
						if(in_array('13',$warrantytypeID))
						{
							$wtype .= ':10 year heat exchanger';
						}
						if(in_array('12',$warrantytypeID))
						{
							$wtype .= ':1/3 commercial use';
						}
						if(in_array('11',$warrantytypeID))
						{
							$wtype .= ':5 year commercial use';
						}
					}
					else if ($product_type == 'commercial' && $prod_type == 'Central Air conditioning Products')
					{
						if(in_array('14',$warrantytypeID))
						{
							$wtype .= ':5 year compressor';
						}
						if(in_array('13',$warrantytypeID))
						{
							$wtype .= ':10 year heat exchanger';
						}
						if(in_array('12',$warrantytypeID))
						{
							$wtype .= ':1/3 commercial use';
						}
						if(in_array('11',$warrantytypeID))
						{
							$wtype .= ':5 year commercial use';
						}
					}
					else if ($product_type == 'commercial' && $prod_type == 'Maxwell Electric water heater Products')
					{
						if(in_array('14',$warrantytypeID))
						{
							$wtype .= ':5 year compressor';
						}
						if(in_array('13',$warrantytypeID))
						{
							$wtype .= ':10 year heat exchanger';
						}
						if(in_array('12',$warrantytypeID))
						{
							$wtype .= ':1/3 commercial use';
						}
						if(in_array('11',$warrantytypeID))
						{
							$wtype .= ':5 year commercial use';
						}
					}
					else if ($product_type == 'residential' && $prod_type == 'Condensing units')
					{
						if(in_array('9',$warrantytypeID))
						{
							$wtype .= ':3 year replacement - No hassle';
						}
						if(in_array('10',$warrantytypeID))
						{
							$wtype .= ':3 year limited parts';
						}
						
						
					}
					else if ($product_type == 'residential' && $prod_type == 'Central Air conditioning Products')
					{
						if(in_array('9',$warrantytypeID))
						{
							$wtype .= ':3 year replacement - No hassle';
						}
						if(in_array('10',$warrantytypeID))
						{
							$wtype .= ':3 year limited parts';
						}
					}
					else if ($product_type == 'residential' && $prod_type == 'Maxwell Electric water heater Products' )
					{
						//$wtype = '3 year limited parts Warranty';
						if(in_array('9',$warrantytypeID))
						{
							$wtype .= '3 year Replacement - No Hassle';
						}
						if(in_array('10',$warrantytypeID))
						{
							$wtype .= '3 year limited parts';
						}
					}
					else if ($ext_warr != '' || $ext_warr == NULL)
					{
						//this block for 3 year replacement warranty.
						$wtype = '3 year limited parts Warranty';
					}
					else
					{
						$wtype = 'No Warranty Available';
					}
					
					
					///
					26 	residential:1 year All parts Base Warranty
					27	residential:5 year  Compressor Warranty
					28	commercial:1 year All parts Base Warranty
					29	commercial:3 year  Compressor Warranty
					30	residential:10 Year  Heat Exchanger Warranty
					31	commercial:5 Year  Heat Exchanger Warranty
					32	residential:3 Year Replacement
					33	residential:3 Year limited parts Warranty
					34	commercial:3 Year Replacement
					35	commercial:3 Year limited parts Warranty
					///
					*/
					$wtype = '';
					/*if(in_array('14',$warrantytypeID))
						{
							$wtype .= ':5 year compressor';
						}
						if(in_array('13',$warrantytypeID))
						{
							$wtype .= ':10 year heat exchanger';
						}
						if(in_array('12',$warrantytypeID))
						{
							$wtype .= ':1/3 commercial use';
						}
						if(in_array('11',$warrantytypeID))
						{
							$wtype .= ':5 year commercial use';
						}
						if(in_array('10',$warrantytypeID))
						{
							$wtype .= ':3 year limited parts';
						}
						if(in_array('9',$warrantytypeID))
						{
							$wtype .= ':3 year replacement - No hassle';
						}*/
						
						if(in_array('26',$warrantytypeID) && $product_type == 'residential')
						{
							$wtype .= ':1 year All parts Base Warranty';
						}
						if(in_array('27',$warrantytypeID) && $product_type == 'residential')
						{
							$wtype .= ':5 year  Compressor Warranty';
						}
						if(in_array('30',$warrantytypeID) && $product_type == 'residential')
						{
							$wtype .= ':10 Year  Heat Exchanger Warranty';
						}
						if(in_array('32',$warrantytypeID) && $product_type == 'residential')
						{
							$wtype .= ':3 Year Replacement Warranty';
						}
						if(in_array('33',$warrantytypeID) && $product_type == 'residential')
						{
							$wtype .= ':3 Year limited parts Warranty';
						}
						if(in_array('28',$warrantytypeID) && $product_type == 'commercial')
						{
							$wtype .= ':1 year All parts Base Warranty';
						}
						if(in_array('29',$warrantytypeID) && $product_type == 'commercial')
						{
							$wtype .= ':3 year  Compressor Warranty';
						}
						if(in_array('31',$warrantytypeID) && $product_type == 'commercial')
						{
							$wtype .= ':5 Year  Heat Exchanger Warranty';
						}
						if(in_array('34',$warrantytypeID) && $product_type == 'commercial')
						{
							$wtype .= ':3 Year Replacement Warranty';
						}
						if(in_array('35',$warrantytypeID) && $product_type == 'commercial')
						{
							$wtype .= ':3 Year limited parts Warranty';
						}
						
						
						// 3 yar extended warr set
						if(isset($ext_warr)){$wtype .= ':3 year extended warranty';}
						
					$tmpwarr= explode(':',$wtype);
					
					//remove blank from array
					for($i=0; $i < sizeof($tmpwarr);$i++)
					{
						if(trim($tmpwarr[$i])=='')
							unset($tmpwarr[$i]);
					}
					
					$wtype = implode(',',$tmpwarr);	
					
					//$wtype="Other Warranty";	
					
				}
				else
				{
					$wtype="Standard Base Warranty";
				} 
					
				/* warranty type ends*/
				$productInfoAddAction_return = $this->productInfoAddAction($this->getRequest()->getPost('hidden_product_info_cnt'),$last_Or_Max_ID[0]['max_id'],$wtype);
				

				if($productInfoAddAction_return)
				{
				
				// multiple recipients
				$to  = $post['email'];

				// subject
				$subject = 'Klimaire: Warranty Product Registration.';

				// message 
				//edited by virendr when as to change email body by Pujan Zaverchand
				/*$message = '
				<html>
				<head>
				  <title>Klimaire: Warranty Product Registration.</title>
				</head>
				<body>
				  <p><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/kilmair/default/images/logo.gif" /></p>
				  <p>Your product has been submitted and will be responded to as soon as possible.</p>
				  <p>Thank you for registering the product.</p>
				  <p>Your Product Confirmation Code is: '.$createNewPostAction_Return.'</p>
				  <p>Click here to claim your registered product/s: <a href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'index.php/warrantyclaim"><b>Warranty CLAIM</b></a></p>
				</body>
				</html>
				';*/
				
				$message = '
				<html>
				<head>
				  <title>Klimaire: Warranty Product Registration.</title>
				</head>
				<body>
				  <p><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/kilmair/default/images/logo.gif" /></p>
				  <p>Thank you for registering the product at <a href="http://www.klimaire.com" target="_blank" >Klimaire.com</a>. Please save the Registration Confirmation Number: '.$createNewPostAction_Return.' for the future reference.</p>
				  <p>We are currently reviewing the registered product details and get back to you at the earliest.</p>
				  <p>Thanking you<br /><a href="http://www.klimaire.com" target="_blank" >Klimaire.com</a></p>
				</body>
				</html>
				';

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: '.ucfirst($post['fname']).' '.ucfirst($post['lname']).' <'.$post['email'].'>' . "\r\n";
				$headers .= 'From: Klimiare: Warranty Products Registration. <'.Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER).'>' . "\r\n";
				//$headers .= 'Cc: a@a.net' . "\r\n";
				//$headers .= 'Bcc: b@a.net' . "\r\n";

				// Mail it
				//mail($to, $subject, $message, $headers);
                                //clear session data array
								
$mail = Mage::getModel('core/email');
$mail->setToName(ucfirst($post['fname']));
$mail->setToEmail($post['email']);
$mail->setBody($message);
$mail->setSubject('Klimiare: Warranty Product Registration.');
$mail->setFromEmail(Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER));
$mail->setFromName("Klimiare: Warranty Product Registration.".Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER));
$mail->setType('html');// YOu can use Html or text as Mail format

//add by virendra when ask to add bcc to vjadeja and biren@sigmasolve.net

$mail1 = Mage::getModel('core/email');
$mail1->setToName(ucfirst('Virendra'));
$mail1->setToEmail('vjadeja@sigmasolve.net');
$mail1->setBody($message);
$mail1->setSubject('Klimiare: Warranty Product Registration.');
$mail1->setFromEmail(Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER));
$mail1->setFromName("Klimiare: Warranty Product Registration.".Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER));
$mail1->setType('html');
try {$mail1->send();}
catch (Exception $e) {
//Mage::getSingleton('core/session')->addError('Unable to send.');
//$this->_redirect('*/*/');
}     


$mail12 = Mage::getModel('core/email');
$mail12->setToName(ucfirst('Biren'));
$mail12->setToEmail('biren@sigmasolve.net');
$mail12->setBody($message);
$mail12->setSubject('Klimiare: Warranty Product Registration.');
$mail12->setFromEmail(Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER));
$mail12->setFromName("Klimiare: Warranty Product Registration.".Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER));
$mail12->setType('html');
try {$mail12->send();}
catch (Exception $e) {
//Mage::getSingleton('core/session')->addError('Unable to send.');
//$this->_redirect('*/*/');
}           
//end of bcc

try {
$mail->send();
Mage::getSingleton('core/session')->addSuccess('Your request has been sent');
//$this->_redirect('*/*/');
}
catch (Exception $e) {
Mage::getSingleton('core/session')->addError('Unable to send.');
//$this->_redirect('*/*/');
}              
								
								
				unset($_SESSION['warranty_reg_prod_data_reserve']);
					Mage::getSingleton('core/session')->addSuccess('Your product has been submitted and will be responded to as soon as possible.<br />Thank you for registering the product.<br />Your Product Confirmation Code is: '.$createNewPostAction_Return);
	
					$this->_redirect('*/*/');
					return;				
				}
				else
				{
                    throw new Exception();
				}
				//echo 'Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.';
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('core/session')->addError('Unable to submit your product submission request. Please, try again later'.$e);
				//echo 'Unable to submit your request. Please, try again later';
                $this->_redirect('*/*/');
                return;
            }
        } 
        else 
        {
            $this->_redirect('*/*/');
            return;
        }
    }
	else if($this->getRequest()->getParam('hidden_reset_flg') == 'set')
	{
		unset($_SESSION['warranty_reg_prod_data_reserve']);
                $this->_redirect('*/*/');
                return;			
	}
    }
    public function confirmedpostAction(){
    try {
        $post = $_SESSION['warranty_reg_data_preserve'];
	$createNewPostAction_Return = $this->createNewPostAction($post);
	if(!$createNewPostAction_Return)
        {
            throw new Exception();					
	}

        Mage::getSingleton('core/session')->addSuccess('Your product registration has been submitted.<br />Thank you for registration');
	unset($_SESSION['warranty_reg_data_preserve']);
	$_SESSION['warranty_reg_succ_data_submit_flag'] = true;
        $this->_redirect('*/*/');
        return;	
	} 
        catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('core/session')->addError('Unable to submit your product registration submission request. Please, try again later');
		//echo 'Unable to submit your request. Please, try again later';
                $this->_redirect('*/*/');
                return;
         }								
	}
    public function checkserialnumberAction()
	{
		$srno= $_REQUEST['srno'];
		$prodcode = $_REQUEST['prodcode'];
		
        $response = false;
		
        $product = Mage::getModel('catalog/product')->load($prodcode);
       	$productSerials = $product['klimaire_serial_numbers'];

		$srNos = explode(',',$productSerials);
		$response = in_array($srno,$srNos);
        //$this->getResponse()->setBody($productSerials.'<'.$prodcode.'>');
		$this->getResponse()->setBody($response);
	}
	
    public function ajaxvalidationAction()
    {
        $response = '';
        $post = $this->getRequest()->getPost();
        $error = false;
        $notCheck_arr = array('apt','State','prodtype','dealer_phno','inst_zip','indoor_prodcode_0','indr_userialno_0');
        $form_label_to_name_mapping_arr = array('Firstname'=>'fname','Lastname'=>'lname','Address1'=>'addr1','Apt/Unit#'=>'apt','Email'=>'email','City'=>'city','State'=>'State','Zip Code'=>'zipcode','Phone'=>'phno','Product Type'=>'prodtype_0','Product Code'=>'prodcode_0','Serial Number'=>'serialno_0','Invoice Number'=>'invoiceno','Date Purchased'=>'purchasedon','Date Installed'=>'installedon','Dealer Name'=>'dealername','Installer Dealer Name'=>'inst_dealername','Installer License Number'=>'inst_licenseno','Installer Dealer Street Address'=>'inst_dealer_street','Installer Phone Number'=>'inst_dealer_ph','Dealer Phone Number'=>'dealer_phno','Installer City'=>'inst_city','State'=>'inst_state','Zip'=>'inst_zip','Installer Dealer Phone Number'=>'inst_dealer_phno');
        $error_cnt = 0;				
        $form_label_to_name_mapping_arr = array_flip($form_label_to_name_mapping_arr);
        foreach(array_keys($post) as $post_key)
        {					
                if (!in_array($post_key,$notCheck_arr) && !Zend_Validate::is(trim($post[$post_key]) , 'NotEmpty')) {
                $error = true;
                if($error_cnt == 0)
                {
                        //$response = "Followings are required. Please, input the data.\n\n";	
                }
                $error_cnt++;
                if($form_label_to_name_mapping_arr[$post_key] != '')
                {

                        $response= $response.'^-&nbsp;'.$form_label_to_name_mapping_arr[$post_key];
                }

            }								
        }
        //check dates
        //$purchasedon = $post['purchasedon'];
        //$installedon = $post['installedon'];
       
        $datetime1 = new DateTime($post['purchasedon']);
        $datetime2 = new DateTime($post['installedon']);
        $interval = $datetime1->diff($datetime2);
                
        
        if(intval($interval->format('%R%a')) < 0)
        {
            $error_cnt++;
            $response= $response.'^-&nbsp;'.'Installed Date must be less than or equal to purchase date';
        }
        for($i=0;$i<10;$i++)
        {
        //$response= $response.'^'.$i;
        //$response= $response.'^'.$post['product_type_cat_'.$i];
        
                                    if(isset($post['product_type_cat_'.$i]))
                                    {
                                        
                                $category = Mage::getModel("catalog/category")->load($post['product_type_cat_'.$i]);
                                //21-yes,22-no
                              /*  if($category['matching_model_and_serial'] == '21')
                                {
                                    if($post['indr_userialno_'.$i]=='')
                                    { 
                                        $error_cnt++;
                                       $response= $response.'^-&nbsp;'.'Please Provide Matching Unit Serial Number';
                                       
                                    }
                                    else
                                    {
										////
										$product = Mage::getModel('catalog/product')->load($post['prodcode_'.$i]);
                                     $serila_numbers = $product['klimaire_serial_numbers'];
                                     $sns = explode(",", $serila_numbers);
                                     $key = in_array($post['serialno_'.$i], $sns);
                                    
                                     if($key != false )
                                     {
                                        //$error_cnt++;
					//$response= $response.'^-&nbsp;'.'Invalid Serial Number';
                                     }
                                     else
                                     {
                                        $read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
                                        $_qur = "select serialno from warrantyregprodchild";
                                        $_res = $read_handler->query($_qur);
                                        $_rows = $_res->fetchAll();
                                        $used_sns= array();
                                        foreach($_rows as $v)
                                        {
                                            $used_sns[] = trim($v['serialno']); 
                                        }
                                        $key2 = in_array($post['serialno_'.$i], $used_sns);
                                        //var_dump($key2);
                                        //exit;
                                        if($key2 == true )
                                        {
                                            $error_cnt++;
                                            $response= $response.'^-&nbsp;'.'Serial number already used. Please provide valid Number';
                                        }
                                     }
										
										////
										
										
										
                                       $product1 = Mage::getModel('catalog/product')->load($post['indoor_prodcode_'.$i]);
                                        $serila_numbers1 = $product1['klimaire_serial_numbers'];
                                        $sns1 = explode(",", $serila_numbers1);
                                        $key1 = in_array($post['indr_userialno_'.$i], $sns1);

                                        if($key1 == false )
                                        {
                                        $error_cnt++;
                                        $response= $response.'^-&nbsp;'.'Invalid Matching Unit Serial Number';
                                        }
                                        else
                                        {
                                        $read_handler1 = Mage::getSingleton('core/resource')->getConnection('core_read');
                                        $_qur1 = "select serialno from warrantyregprodchild";
                                        $_res1 = $read_handler1->query($_qur1);
                                        $_rows1 = $_res1->fetchAll();
                                        $used_sns1= array();
                                        foreach($_rows1 as $v1)
                                        {
                                                $used_sns1[] = trim($v1['serialno']); 
                                        }
                                        $key21 = in_array($post['indr_userialno_'.$i], $used_sns1);
										
                                        if($key21 == true )
                                        {
                                                $error_cnt++;
                                                $response= $response.'^-&nbsp;'.'Matching Unit Serial Number already used. Please provide valid Number';
                                        }
                                        } 
                                    }
                                
                                }
                                else {
                                */  
                                     $product = Mage::getModel('catalog/product')->load($post['prodcode_'.$i]);
                                     $serila_numbers = $product['klimaire_serial_numbers'];
                                     $sns = explode(",", $serila_numbers);
                                     $key = in_array($post['serialno_'.$i], $sns);
                                    
                                     if($key != false )
                                     {
                                        //$error_cnt++;
					//$response= $response.'^-&nbsp;'.'Invalid Serial Number';
                                     }
                                     else
                                     {
                                        $read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
                                        $_qur = "select serialno from warrantyregprodchild";
                                        $_res = $read_handler->query($_qur);
                                        $_rows = $_res->fetchAll();
                                        $used_sns= array();
                                        foreach($_rows as $v)
                                        {
                                            $used_sns[] = trim($v['serialno']); 
                                        }
                                        $key2 = in_array($post['serialno_'.$i], $used_sns);
                                        //var_dump($key2);
                                        //exit;
                                        if($key2 == true )
                                        {
                                            $error_cnt++;
                                            $response= $response.'^-&nbsp;'.'Serial number already used. Please provide valid Number';
                                        }
                                     }
                                   // }
                                    
                                    }
        }
        
        
        
        $this->getResponse()->setBody($response);
    }
    public function ajaxAction(){
		$response = '';
		$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
		if($this->getRequest()->getPost('serialno_0') != '') 
		{
			$_qur = "select warrantyregprodID from warrantyregprodchild where serialno = '".$this->getRequest()->getPost('serialno_0')."'";
			$_res = $read_handler->query($_qur);
			$_row = $_res->fetchAll();
			if(count($_row) > 0)
			{
				$response .= 'serialno';
			}
		}

		$response .= '__#__';//.$this->getRequest()->getPost('serialno').'__#__';
		
		if($this->getRequest()->getPost('indr_userialno_0') != '') 
		{
			$_qur1 = "select warrantyregprodID from warrantyregprodchild where indr_userialno = '".$this->getRequest()->getPost('indr_userialno_0')."'";
						
			$_res1 = $read_handler->query($_qur1);
			$_row1 = $_res1->fetchAll();			
			if(count($_row1) > 0)
			{
				$response .= 'indr_userialno';	
			}			
			
		}
		
		$this->getResponse()->setBody($response);
		//$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}
    public function ajaxcategoryAction(){
    $cat_id= $_REQUEST['cat_id'];
    //$response = '<option value="" selected >-Select Model-</option>';
	$response = '=-Select Model-';
    $category_model = Mage::getModel('catalog/category'); 
    $_category = $category_model->load($cat_id);      
    $all_child_categories = $category_model->getResource()->getAllChildren($_category); 
	$tmpproducts = array();
	$tmpproducts[0]=$response;
	$i=1;
		foreach($all_child_categories as $newcategory)
		{
			 $catagory_model1 = Mage::getModel('catalog/category')->load($newcategory); 
			 $collection = Mage::getResourceModel('catalog/product_collection');
			 $collection->addCategoryFilter($catagory_model1);
			 $collection->addAttributeToFilter('status',1);
			 $collection->addAttributeToSelect(array('name','entity_id')); 
			 $collection->addStoreFilter();
			 foreach ($collection as $_product){
				//$response.=  '|<option value="'. $_product['entity_id'].'" >'.$_product['name'].'</option>';
				$tmpproducts[$i] = $_product['entity_id'].'='.$_product['name'];
				$i++;
				//$response.=  '|'. $_product['entity_id'].'='.$_product['name'];
				}
				
		}
		//$this->getResponse()->setBody($response);
        $this->getResponse()->setBody(implode('|',array_unique($tmpproducts)));
}


    public function matchingunitmodelnumberAction(){
        $ele_id= $_REQUEST['ele_id'];
        //$response = '<option value="" selected >-Select Model-</option>';
		$response = '=-Select Model-';
        $product = Mage::getModel('catalog/product')->load($_REQUEST['prdcode']);
        $crossproducts=$product->getCrossSellProducts();
        foreach($crossproducts as $crossproduct)
        {
            $products1 = Mage::getModel('catalog/product')->load($crossproduct->getId());
            
			$response.=  '|'. $products1['entity_id'].'='.$products1['name'];
        }
         $this->getResponse()->setBody($response);
    }
    // ********* //// Save/Insert the posted Data to Model "warrantyregprod". //// *********
    public function createNewPostAction($data) {
		$warrantyregprod = Mage::getModel('warrantyregprod/warrantyregprod');
		
		// ******* Check the uniqueness/existance of confirmation code before successfull registration. *******

		$chk_confirmcode_coll_obj = $warrantyregprod->getCollection();
		$chk_confirmcode_coll_tmparr = array();
		foreach($chk_confirmcode_coll_obj as $obj)
        {
			$chk_confirmcode_coll_tmparr[] = $obj->getConfirmcode();	
        }

		function ComposeConfirmationCode($prodcode)
		{
			/*
			Registration Code: first 4 digits of product code +YYMMDD+000(sequence#)
			Example for KSWM012-H113....... registration code    KSWM111021123			
			*/
			
			$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
			$_qur = "select max(warrantyregprod_id) as warrantyregprod_id from warrantyregprod";
			$_res = $read_handler->query($_qur);
			$_row = $_res->fetch();
			$_row['warrantyregprod_id']++;
			return substr($prodcode,0,4).date('y').date('m').date('d').str_pad($_row['warrantyregprod_id'], 3, "0", STR_PAD_LEFT);
			
		}
		
		// Recursive Function to Chk existence of confirm code.
		function Recurse_confirmCode($prodcode)
		{	
			$Composed_ConfirmationCode = ComposeConfirmationCode($prodcode);							
			if(in_array($Composed_ConfirmationCode,$chk_confirmcode_coll_tmparr))
			{
				Recurse_confirmCode($prodcode);
			}
			else
			{
				unset($chk_confirmcode_coll_tmparr);
				return $Composed_ConfirmationCode;
			}			
		}
		// Recursive Function to Chk existence of confirm code.

		
		// Init the Recursive function call
		$final_ConfirmationCode = Recurse_confirmCode($data['prodcode_0']);
		
		// Init the Recursive function call
		
										
		// ******* Check the uniqueness/existance of confirmation code before successfull registration. *******
			
		// Setting Up the data to model to save them in db.
		foreach($data as $data_key => $data_val)
		{			
			$data_key = ucfirst($data_key);
			$methodName = "set".$data_key;
			$warrantyregprod->$methodName(trim($data_val));
		}
		$warrantyregprod->setConfirmcode($final_ConfirmationCode);
		$warrantyregprod->setCreated_time(date('Y-m-d H:i:s'));
		$warrantyregprod->setStatus('1');
		
		// Setting Up the data to model to save them in db.
			
		if($warrantyregprod->save())
		return $final_ConfirmationCode;//true;
		else
		return false;
	}
    // ********* //// Save/Insert the posted Data to Model "warrantyregprod". //// *********
    public function getProductNamebyId($pid)
    {
        $model = Mage::getModel('catalog/product');
        $_product = $model->load($pid);
        return $_product->getName();
    }
    // ********* //// add product specific information into child table of "warrantyregprod". //// *********	
    public function productInfoAddAction($hidden_posted_product_info_cnt,$warrantyregprod_id, $wtype){
		if($hidden_posted_product_info_cnt > 0)
		{
			$write_handler = Mage::getSingleton('core/resource')->getConnection('core_write');
			for($i=0; $i <= $hidden_posted_product_info_cnt; $i++)
			{
			
			if($this->getRequest()->getPost('prodtype_'.$i) != '' && is_numeric($warrantyregprod_id) && $warrantyregprod_id != '')
			{
				$query_insert_arr1 = array();
				$query_insert_arr2 = array();
			
				$query_insert_arr1[] = '`warrantyregprodID`';
				$query_insert_arr2[] = "'".$warrantyregprod_id."'";
								
				if($this->getRequest()->getPost('prodtype_'.$i) != '')
				{
					$query_insert_arr1[] = '`prodtype`';
					$query_insert_arr2[] = "'".$this->getRequest()->getPost('prodtype_'.$i)."'";
				}
				
				if($this->getRequest()->getPost('prodcode_'.$i) != '')
				{
					$query_insert_arr1[] = '`prodcode`';
					//$query_insert_arr2[] = "'".$this->getRequest()->getPost('prodcode_'.$i)."'";			
                                        $query_insert_arr2[] = "'".$this->getProductNamebyId($this->getRequest()->getPost('prodcode_'.$i))."'";
				}
				
				if($this->getRequest()->getPost('serialno_'.$i) != '')
				{
					$query_insert_arr1[] = '`serialno`';
					$query_insert_arr2[] = "'".$this->getRequest()->getPost('serialno_'.$i)."'";
				}
				
				if($this->getRequest()->getPost('indoor_prodcode_'.$i) != '')
				{
					$query_insert_arr1[] = '`indr_prodcode`';
					//$query_insert_arr2[] = "'".$this->getRequest()->getPost('indoor_prodcode_'.$i)."'";			
                                        $query_insert_arr2[] = "'".$this->getProductNamebyId($this->getRequest()->getPost('indoor_prodcode_'.$i))."'";
				}
				
				if($this->getRequest()->getPost('indr_userialno_'.$i) != '')
				{
					$query_insert_arr1[] = '`indr_userialno`';
					$query_insert_arr2[] = "'".$this->getRequest()->getPost('indr_userialno_'.$i)."'";			
				}
				
				//insert warranty type
				$query_insert_arr1[] = '`warr_type`';
				$query_insert_arr2[] = "'".$wtype."'";
				
				$query_insert_str1 = implode(',',$query_insert_arr1);
				$query_insert_str2 = implode(',',$query_insert_arr2);
				
				$query_insert = "insert into warrantyregprodchild (".$query_insert_str1.") values (".$query_insert_str2.")";
				$result_Inserted = $write_handler->query($query_insert);				
			}
			
			} 
			return true;
		}
		else
		{
			return false;
		}
	}
    // ********* //// add product specific information into child table of "warrantyregprod". //// *********			
}