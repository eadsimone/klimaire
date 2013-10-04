<?php

/**
 * |___  /                   | |     | |    |___  /
 *    / / _ __ ___   ___   __| |_   _| | ___   / /   ___ ___  _ __ ___
 *   / / | '_ ` _ \ / _ \ / _` | | | | |/ _ \ / /   / __/ _ \| '_ ` _ \
 *  / /__| | | | | | (_) | (_| | |_| | |  __// /__ | (_| (_) | | | | | |
 * /_____|_| |_| |_|\___/ \__,_|\__,_|_|\___/_____(_)___\___/|_| |_| |_|
 *
 *
 * FedEx National LTL Shipping Extension
 *
 * @category   ZmoduleZ
 * @package    ZmoduleZ_FedexNationalLTLModule
 * @copyright  Copyright (c) 2009 ZmoduleZ (http://www.zmodulez.com)
 * @license    http://www.zmodulez.com/license/license.txt
 * @author     sales@zmodulez.com>
 * @version    1.6.0
 */
class ZmoduleZ_FedexNationalLTLModule_Model_Carrier_Fedexnationalltl extends ZmoduleZ_FedexNationalLTLModule_Model_Carrier_Abstractfedexfreight {

	protected $_code = 'fedexnationalltl';

	protected function _getCarrierCode(){
		return 'fedexnationalltl';
	}

	protected function _getOpco(){
		Mage::log("getting code for nation ltl");
		//return "FXNL";
		return "Economy";
	}
}