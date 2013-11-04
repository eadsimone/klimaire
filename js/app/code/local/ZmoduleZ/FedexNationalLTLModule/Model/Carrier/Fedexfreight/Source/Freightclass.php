<?php

/**
 * |___  /                   | |     | |    |___  /                     
 *    / / _ __ ___   ___   __| |_   _| | ___   / /   ___ ___  _ __ ___  
 *   / / | '_ ` _ \ / _ \ / _` | | | | |/ _ \ / /   / __/ _ \| '_ ` _ \ 
 *  / /__| | | | | | (_) | (_| | |_| | |  __// /__ | (_| (_) | | | | | |
 * /_____|_| |_| |_|\___/ \__,_|\__,_|_|\___/_____(_)___\___/|_| |_| |_|
 * 
 * 
 * FedEx Freight Shipping Extension
 *
 * @category   ZmoduleZ
 * @package    ZmoduleZ_FedexNationalLTLModule
 * @copyright  Copyright (c) 2009 ZmoduleZ (http://www.zmodulez.com)
 * @license    http://www.zmodulez.com/license/license.txt
 * @author     sales@zmodulez.com>
 * @version    1.2.0 
 */
class ZmoduleZ_FedexNationalLTLModule_Model_Carrier_FedExFreight_Source_Freightclass
{
    public function toOptionArray()
    {
        $fedFreight = Mage::getSingleton('fedexnationalltlmodule/carrier_fedexnationalltl');
        $arr = array();
        foreach ($fedFreight->getCode('freight_class') as $k=>$v) {
            $arr[] = array('value'=>$k, 'label'=>$v);
        }
        return $arr;
    }
}