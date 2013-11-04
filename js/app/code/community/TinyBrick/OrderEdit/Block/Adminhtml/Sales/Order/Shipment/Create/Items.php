<?php
/**
 * Open Commerce LLC Commercial Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Commerce LLC Commercial Extension License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.tinybrick.com/license/commercial-extension
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@tinybrick.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this package to newer
 * versions in the future. 
 *
 * @category   TinyBrick
 * @package    TinyBrick_OrderEdit
 * @copyright  Copyright (c) 2010 TinyBrick Inc. LLC
 * @license    http://www.tinybrick.com/license/commercial-extension
 */
class TinyBrick_OrderEdit_Block_Adminhtml_Sales_Order_Shipment_Create_Items extends Mage_Adminhtml_Block_Sales_Order_Shipment_Create_Items

{

    public function canCreateShippingLabel()
    {
            $carrier = $this->getOrder()->getShippingCarrier();
            if(method_exists($carrier, 'isShippingLabelsAvailable')) {
                return $carrier->isShippingLabelsAvailable();
            } else {
                return false;
            }
    }
    
    
}