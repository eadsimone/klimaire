<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Contacts
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Contacts index controller
 *
 * @category   Mage
 * @package    Mage_Contacts
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Contacts_IndexController extends Mage_Core_Controller_Front_Action
{

    const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';

    public function preDispatch()
    {
        parent::preDispatch();

        if( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
            $this->norouteAction();
        }
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('contactForm')
            ->setFormAction( Mage::getUrl('*/*/post') );

        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
    }

    public function postAction()
    {
		
		try
		{

		$post =  $this->getRequest()->getPost();
		//$createNewPostAction_Return = $this->createNewPostAction($post);
				if(!$post){
                    throw new Exception();					
				}

				// multiple recipients
				//$to  = $post['email'];
				//$to1  = "Warranty@Klimare.com";
				$to1  = "vtajpara@sigmasolve.com";
				// subject
				$subject = 'Klimaire: Warranty Claim Registration.';
				$subject1 = 'Klimaire: Warranty Claim Registration.';
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
				    <td width="16%"> ' .$post["name"]. '				    
				    </td>

				  </tr>
				  
				  <tr><td valign="top" align="left" height="30" colspan="3">
				  <div style="position:absolute;margin:0 0 0 112px;">
				<table width="100%" cellspacing="1" cellpadding="1" border="0" align="center">
				  <tbody><tr> 
				    <td width="85" valign="top" align="left"><strong><label for="zip_radio">Zip Code:</label></strong></td>
				    <td valign="top" align="left"> ' .$comment. '</td>


				    <td width="103" valign="top" align="left"><strong><label for="phno_radio">Phone No.:</label></strong></td>
				    <td valign="top" align="left">' .$email. '</td>
				    <td width="85" valign="top" align="left"><strong><label for="srno_radio">Serial No.:</label></strong></td>
				  </tr>  
				</tbody></table>
				<br>
				</body>
				</html>
				';
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: '.ucfirst($post['name']).' '.ucfirst($post['comment']).' <'.$post['email'].'>' . "\r\n";
				$headers .= 'From: Klimiare: Warranty Claim Registration. <'.Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER).'>' . "\r\n";



				//$headers .= 'Cc: a@a.com' . "\r\n";
				//$headers .= 'Bcc: s@a.com' . "\r\n";

// To send HTML mail, the Content-type header must be set
				$headers1  = 'MIME-Version: 1.0' . "\r\n";
				$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers1 .= 'To: Klimaiare Admin <vtajpara@sigmasolve.com>' . "\r\n";
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

}
