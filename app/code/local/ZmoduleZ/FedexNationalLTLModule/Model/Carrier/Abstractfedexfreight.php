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
 * @package    ZmoduleZ_FedexFreightModule
 * @copyright  Copyright (c) 2009 ZmoduleZ (http://www.zmodulez.com)
 * @license    http://www.zmodulez.com/license/license.txt
 * @author     sales@zmodulez.com>
 * @version    1.6.0
 */
abstract class ZmoduleZ_FedexNationalLTLModule_Model_Carrier_Abstractfedexfreight extends Mage_Usa_Model_Shipping_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

	protected $_request = null;
	protected $_result = null;
	protected $_xmlAccessRequest = null;

	abstract protected function _getOpco();
	abstract protected function _getCarrierCode();

	public function _getQuotes() {
		Mage::log("getting quotes...");

		// if fixed rate is used, don't call the xml service.  Use handling fees to obtain rates
		if ($this->getConfigFlag('usefixedrate')){
			$expectedArrivalDate = strftime("%a, %m/%d/%Y", mktime(0, 0, 0, date("m")  , date("d")+$this->getConfigData('adddaystodeliverydate'), date("Y")));
			$result = Mage::getModel('shipping/rate_result');
			$result->append($this->buildRate($expectedArrivalDate, 0, $this->getConfigData('methodtext'), 0, 0));
			return $result;
		}

		$r = $this->_rawRequest;
		$params = array (
				'regKey' => Mage::helper('core')->decrypt($this->getConfigData('key')),
				'as_opco' => $this->_getOpco(),
				'as_guarantee' => $this->getConfigData('guarantee') == "1" ? "Y" : "N",
				'as_iamthe' => $this->getConfigData('requestor_type'), #[shipper, consignee or billto]
				'as_shipterms' => "prepaid",

		#if billto use the following:
				'as_billto_address' => $this->getConfigData('billto_address'),
				'as_billto_city' => $this->getConfigData('billto_city'),
				'as_billto_state' => $this->getConfigData('billto_state'),
				'as_billto_zip' => $this->getConfigData('billto_zip'),
				'as_billto_country' => $this->getConfigData('billto_country'),
				'as_shzip' => $r->getOrigPostal(),
				'as_shcntry' => $r->getOrigCountry(),
				'as_cnzip' => $r->getDestPostal(),
				'as_cncntry' => $r->getDestCountry(),
				'as_class1' => $this->getCode('freight_class', $this->getConfigData('freight_class')),
				'as_pkgtype1' => $this->getConfigData('package_type'),

				'as_weight1' => intval($r->getWeight())+""+$this->getConfigData('palletweight'));

		// append account number if it's provided
		if (!is_null($this->getConfigData('account')) && $this->getConfigData('account') != ""){
			$params['as_acctnbr'] = Mage::helper('core')->decrypt($this->getConfigData('account'));
		}
		Mage::log("Sending the following parameters to Fedex Freight");
		Mage::log($params);
		try {
			$url = 'http://fedexfreight.fedex.com/XMLLTLRatingNoCity.jsp';
			$client = new Zend_Http_Client();
			$client->setUri($url);
			$client->setConfig(array (
					'maxredirects' => 0,
					'timeout' => 30
			));
			$client->setParameterGet($params);
			$response = $client->request();
			Mage::log($response);
			$responseBody = $response->getBody();
		} catch (Exception $e) {

			$responseBody = '';
		}

		return $this->_parseXmlResponse($responseBody);
	}

	public function _getQuotesLiftGate() {
		Mage::log("getting LiftGate quotes...");

		// if fixed rate is used, don't call the xml service.  Use handling fees to obtain rates
		if ($this->getConfigFlag('usefixedrate')){
			$expectedArrivalDate = strftime("%a, %m/%d/%Y", mktime(0, 0, 0, date("m")  , date("d")+$this->getConfigData('adddaystodeliverydate'), date("Y")));
			$result = Mage::getModel('shipping/rate_result');
			$result->append($this->buildRate($expectedArrivalDate, 0, $this->getConfigData('methodtext'), 0, 0));
			return $result;
		}

		$r = $this->_rawRequest;
		$params = array (
				'regKey' => Mage::helper('core')->decrypt($this->getConfigData('key')),
				'as_opco' => $this->_getOpco(),
				'as_guarantee' => $this->getConfigData('guarantee') == "1" ? "Y" : "N",
				'as_iamthe' => $this->getConfigData('requestor_type'), #[shipper, consignee or billto]
				'as_shipterms' => "prepaid",

		#if billto use the following:
				'as_billto_address' => $this->getConfigData('billto_address'),
				'as_billto_city' => $this->getConfigData('billto_city'),
				'as_billto_state' => $this->getConfigData('billto_state'),
				'as_billto_zip' => $this->getConfigData('billto_zip'),
				'as_billto_country' => $this->getConfigData('billto_country'),
				'as_shzip' => $r->getOrigPostal(),
				'as_shcntry' => $r->getOrigCountry(),
				'as_cnzip' => $r->getDestPostal(),
				'as_cncntry' => $r->getDestCountry(),
				'as_class1' => $this->getCode('freight_class', $this->getConfigData('freight_class')),
				'as_pkgtype1' => $this->getConfigData('package_type'),
				'as_liftgate' => "Y",
				'as_weight1' => intval($r->getWeight())+""+$this->getConfigData('palletweight'));

		// append account number if it's provided
		if (!is_null($this->getConfigData('account')) && $this->getConfigData('account') != ""){
			$params['as_acctnbr'] = Mage::helper('core')->decrypt($this->getConfigData('account'));
		}
		Mage::log("Sending the following parameters to Fedex Freight");
		Mage::log($params);
		try {
			$url = 'http://fedexfreight.fedex.com/XMLLTLRatingNoCity.jsp';
			$client = new Zend_Http_Client();
			$client->setUri($url);
			$client->setConfig(array (
					'maxredirects' => 0,
					'timeout' => 30
			));
			$client->setParameterGet($params);
			$response = $client->request();
			Mage::log($response);
			$responseBody = $response->getBody();
		} catch (Exception $e) {

			$responseBody = '';
		}

		return $this->_parseXmlResponse2($responseBody);
	}

		public function _getQuotesLimitedAccess() {
		Mage::log("getting Limited Access quotes...");

		// if fixed rate is used, don't call the xml service.  Use handling fees to obtain rates
		if ($this->getConfigFlag('usefixedrate')){
			$expectedArrivalDate = strftime("%a, %m/%d/%Y", mktime(0, 0, 0, date("m")  , date("d")+$this->getConfigData('adddaystodeliverydate'), date("Y")));
			$result = Mage::getModel('shipping/rate_result');
			$result->append($this->buildRate($expectedArrivalDate, 0, $this->getConfigData('methodtext'), 0, 0));
			return $result;
		}

		$r = $this->_rawRequest;
		$params = array (
				'regKey' => Mage::helper('core')->decrypt($this->getConfigData('key')),
				'as_opco' => $this->_getOpco(),
				'as_guarantee' => $this->getConfigData('guarantee') == "1" ? "Y" : "N",
				'as_iamthe' => $this->getConfigData('requestor_type'), #[shipper, consignee or billto]
				'as_shipterms' => "prepaid",

		#if billto use the following:
				'as_billto_address' => $this->getConfigData('billto_address'),
				'as_billto_city' => $this->getConfigData('billto_city'),
				'as_billto_state' => $this->getConfigData('billto_state'),
				'as_billto_zip' => $this->getConfigData('billto_zip'),
				'as_billto_country' => $this->getConfigData('billto_country'),
				'as_shzip' => $r->getOrigPostal(),
				'as_shcntry' => $r->getOrigCountry(),
				'as_cnzip' => $r->getDestPostal(),
				'as_cncntry' => $r->getDestCountry(),
				'as_class1' => $this->getCode('freight_class', $this->getConfigData('freight_class')),
				'as_pkgtype1' => $this->getConfigData('package_type'),
				'as_limitedaccessdelivery' => "Y",
				'as_weight1' => intval($r->getWeight())+""+$this->getConfigData('palletweight'));

		// append account number if it's provided
		if (!is_null($this->getConfigData('account')) && $this->getConfigData('account') != ""){
			$params['as_acctnbr'] = Mage::helper('core')->decrypt($this->getConfigData('account'));
		}
		Mage::log("Sending the following parameters to Fedex Freight");
		Mage::log($params);
		try {
			$url = 'http://fedexfreight.fedex.com/XMLLTLRatingNoCity.jsp';
			$client = new Zend_Http_Client();
			$client->setUri($url);
			$client->setConfig(array (
					'maxredirects' => 0,
					'timeout' => 30
			));
			$client->setParameterGet($params);
			$response = $client->request();
			Mage::log($response);
			$responseBody = $response->getBody();
		} catch (Exception $e) {

			$responseBody = '';
		}

		return $this->_parseXmlResponse2($responseBody);
	}
	public function _parseXmlResponse2($response) {

		if (preg_match('#<\?xml version="1.0"\?>#', $response)) {
			$response = str_replace('<?xml version="1.0"?>', '<?xml version="1.0" encoding="ISO-8859-1"?>', $response);
		}
		$ret_arr = array();
		$netFreightCharge = null;
		$xml = null;
		if (isset($response) && $response !== '') {
			$xml = simplexml_load_string($response);
			if (isset($xml) && $xml !== '' && isset($xml->{'net-freight-charges'})){
				$netFreightCharge =  floatval($xml->{'net-freight-charges'});
			}
			else {
				Mage::log("Unable to load xml from response.");
			}
		}
		else {
			Mage::log("XML Response was null.");
		}

		$result = Mage::getModel('shipping/rate_result');
		if (!isset($netFreightCharge) || is_null($netFreightCharge)) {
			Mage::log('ERROR in response quote.  Net Freight Charge='.$netFreightCharge);
			Mage::log('Response XML Response Message:');
			Mage::log($xml);
			$error = Mage::getModel('shipping/rate_result_error');
			$error->setCarrier('fedexnationalltl');
			$error->setCarrierTitle($this->getConfigData('title'));
			$error->setErrorMessage($this->getConfigData('specificerrmsg'));
			$result->append($error);
		}
		else {
			$transitDays = intval($xml->{'transit-days'});
			$expectedArrivalDate = strftime("%a, %m/%d/%Y", mktime(0, 0, 0, date("m")  , date("d")+$transitDays+$this->getConfigData('adddaystodeliverydate'), date("Y")));

			
		}
		
		$ret_arr[0]= $expectedArrivalDate;
		$ret_arr[1]= $netFreightCharge;
		
		return $ret_arr;
	}
	public function _parseXmlResponse($response) {

		if (preg_match('#<\?xml version="1.0"\?>#', $response)) {
			$response = str_replace('<?xml version="1.0"?>', '<?xml version="1.0" encoding="ISO-8859-1"?>', $response);
		}

		$netFreightCharge = null;
		$xml = null;
		if (isset($response) && $response !== '') {
			$xml = simplexml_load_string($response);
			if (isset($xml) && $xml !== '' && isset($xml->{'net-freight-charges'})){
				$netFreightCharge =  floatval($xml->{'net-freight-charges'});
			}
			else {
				Mage::log("Unable to load xml from response.");
			}
		}
		else {
			Mage::log("XML Response was null.");
		}

		$result = Mage::getModel('shipping/rate_result');
		if (!isset($netFreightCharge) || is_null($netFreightCharge)) {
			Mage::log('ERROR in response quote.  Net Freight Charge='.$netFreightCharge);
			Mage::log('Response XML Response Message:');
			Mage::log($xml);
			$error = Mage::getModel('shipping/rate_result_error');
			$error->setCarrier('fedexnationalltl');
			$error->setCarrierTitle($this->getConfigData('title'));
			$error->setErrorMessage($this->getConfigData('specificerrmsg'));
			$result->append($error);
		}
		else {
			$transitDays = intval($xml->{'transit-days'});
			$expectedArrivalDate = strftime("%a, %m/%d/%Y", mktime(0, 0, 0, date("m")  , date("d")+$transitDays+$this->getConfigData('adddaystodeliverydate'), date("Y")));

			$result->append($this->buildRate($expectedArrivalDate, $netFreightCharge, $this->getConfigData('methodtext'), 0, 0));
			if ($this->getConfigFlag('showResidentialFee')){
				$result->append($this->buildRate($expectedArrivalDate,$netFreightCharge,$this->getConfigData('residentialratetext'),$this->getConfigData('residentialfee'), 1));
			}
			//liftgate
			$newLiftgateRate = $this->_getQuotesLiftGate();
			$result->append($this->buildRate($newLiftgateRate[0], $newLiftgateRate[1], "Freight (Lift Gate)", 0, 2));
			
			//limitedaccess
			$newLimitedAccessRate = $this->_getQuotesLimitedAccess();
			$result->append($this->buildRate($newLimitedAccessRate[0], $newLimitedAccessRate[1], "Freight (Limited Access)", 0, 3));
			
		}

		return $result;
	}

	public function buildRate($expectedArrivalDateString, $netFreightChargeAmt, $methodText, $rDeliveryAmt, $idx) {
		$rate = Mage::getModel('shipping/rate_result_method');
		$method = $rate['service'];
		$rate->setCarrier($this->_getCarrierCode());
		$rate->setCarrierTitle($this->getConfigData('title'));
		$rate->setMethod($method+$idx);
		$deliveryDateMsg = "";
		if ($this->getConfigFlag('showdeliverydatemsg')){
			$deliveryDateMsg =	htmlspecialchars("(Expected delivery by $expectedArrivalDateString)");
		}

		$rate->setMethodTitle($methodText." ".$deliveryDateMsg);
		$rate->setCost($this->getMethodPrice($netFreightChargeAmt+$rDeliveryAmt, '') );
		$rate->setPrice($this->getMethodPrice($netFreightChargeAmt+$rDeliveryAmt, ''));
		return $rate;
	}

	public function collectRates(Mage_Shipping_Model_Rate_Request $request) {
		$this->setRequest($request);
		$this->_result = $this->_getQuotes();
		if (!$this->getConfigFlag('active') || (intval($this->_rawRequest->getWeight()) < $this->getConfigData('activation_weight'))) {
			return false;
		}
		return $this->getResult();
	}

	public function getMethodPrice($cost, $method='')
	{
		if ($method == $this->getConfigData('free_method') &&
		$this->getConfigData('free_shipping_enable') &&
		$this->getConfigData('free_shipping_subtotal') < $this->_rawRequest->getValueWithDiscount())
		{
			$price = '0.00';
		} else {
			$priceWithFee1 = $this->getFinalPriceWithHandlingFees($cost, $this->getConfigData('handling1_fee'), $this->getConfigData('handling1_type'), $this->getConfigData('handling1_action'));
			$price = $this->getFinalPriceWithHandlingFees($priceWithFee1, $this->getConfigData('handling2_fee'), $this->getConfigData('handling2_type'), $this->getConfigData('handling2_action'));
		}
		return $price;
	}

	public function getFinalPriceWithHandlingFees($cost, $handlingFee, $handlingType, $handlingAction)
	{
		//$handlingFee = $this->getConfigData('handling2_fee');
		$finalMethodPrice = 0;
		//$handlingType = $this->getConfigData('handling2_type');
		if (!$handlingType) {
			$handlingType = self::HANDLING_TYPE_FIXED;
		}
		//$handlingAction = $this->getConfigData('handling2_action');
		if (!$handlingAction) {
			$handlingAction = self::HANDLING_ACTION_PERORDER;
		}
		if($handlingAction == self::HANDLING_ACTION_PERPACKAGE)
		{
			if ($handlingType == self::HANDLING_TYPE_PERCENT) {
				$finalMethodPrice = ($cost + ($cost * $handlingFee/100)) * $this->_numBoxes;
			} else {
				$finalMethodPrice = ($cost + $handlingFee) * $this->_numBoxes;
			}
		} else {
			if ($handlingType == self::HANDLING_TYPE_PERCENT) {
				$finalMethodPrice = ($cost * $this->_numBoxes) + ($cost * $this->_numBoxes * $handlingFee/100);
			} else {
				$finalMethodPrice = ($cost * $this->_numBoxes) + $handlingFee;
			}
		}
		return $finalMethodPrice;
	}

	public function setRequest(Mage_Shipping_Model_Rate_Request $request) {
		$this->_request = $request;
		$r = new Varien_Object();

		if ($request->getOrigCountry()) {
			$origCountry = $request->getOrigCountry();
		} else {
			$origCountry = Mage :: getStoreConfig('shipping/origin/country_id', $this->getStore());
		}
		$r->setOrigCountry(Mage :: getModel('directory/country')->load($origCountry)->getIso2Code());

		if ($request->getOrigRegionCode()) {
			$origRegionCode = $request->getOrigRegionCode();
		} else {
			$origRegionCode = Mage :: getStoreConfig('shipping/origin/region_id', $this->getStore());
			if (is_numeric($origRegionCode)) {
				$origRegionCode = Mage :: getModel('directory/region')->load($origRegionCode)->getCode();
			}
		}
		$r->setOrigRegionCode($origRegionCode);

		if ($request->getOrigPostcode()) {
			$r->setOrigPostal($request->getOrigPostcode());
		} else {
			$r->setOrigPostal(Mage :: getStoreConfig('shipping/origin/postcode', $this->getStore()));
		}

		if ($request->getOrigCity()) {
			$r->setOrigCity($request->getOrigCity());
		} else {
			$r->setOrigCity(Mage :: getStoreConfig('shipping/origin/city', $this->getStore()));
		}

		if ($request->getDestCountryId()) {
			$destCountry = $request->getDestCountryId();
		} else {
			$destCountry = self :: USA_COUNTRY_ID;
		}

		//for UPS, puero rico state for US will assume as puerto rico country
		if ($destCountry == self :: USA_COUNTRY_ID && ($request->getDestPostcode() == '00912' || $request->getDestRegionCode() == self :: PUERTORICO_COUNTRY_ID)) {
			$destCountry = self :: PUERTORICO_COUNTRY_ID;
		}

		$r->setDestCountry(Mage :: getModel('directory/country')->load($destCountry)->getIso2Code());

		$r->setDestRegionCode($request->getDestRegionCode());

		if ($request->getDestPostcode()) {
			$r->setDestPostal($request->getDestPostcode());
		} else {

		}

		$weight = $this->getTotalNumOfBoxes($request->getPackageWeight());
		$r->setWeight($weight);

		$this->_rawRequest = $r;

		return $this;
	}

	public function getResult() {
		return $this->_result;
	}

	public function getCode($type, $code = '') {
		$codes = array (
            'method'=>array(
                'STANDARD' => 'Standard Service (commercial delivery)',
				'liftgate_delivery' => 'Freight (Lift Gate)',
				'Limited_Access_Delivery' => 'Freight (Limited Access)',
            ),
			'freight_class' => array (
				'050' => '050',
				'055' => '055',
				'060' => '060',
				'065' => '065',
				'070' => '070',
				'077' => '077',
				'075' => '075',
				'080' => '080',
				'085' => '085',
				'092' => '092',
				'100' => '100',
				'110' => '110',
				'125' => '125',
				'150' => '150',
				'200' => '200',
				'250' => '250',
				'300' => '300',
				'400' => '400',
				'500' => '500',
		),
			'package_type' => array (
				'SKID' => 'Skid (default)',
				'OTHR' => 'Other',
				'CRAT' => 'Crate',
				'DRUM' => 'Drum',
				'BNDL' => 'Bundle',
				'LOOS' => 'Loose',
				'CTN'  => 'Carton',
		),
			'requester_type' => array (
				'billto'    => 'Bill To (requires a Bill To address)',
				'shipper'   => 'Shipper',
				'consignee' => 'Consignee',
		),
		);

		if (!isset ($codes[$type])) {
			//            throw Mage::exception('Mage_Shipping', Mage::helper('usa')->__('Invalid UPS CGI code type: %s', $type));
			return false;
		}
		elseif ('' === $code) {
			return $codes[$type];
		}

		if (!isset ($codes[$type][$code])) {
			//            throw Mage::exception('Mage_Shipping', Mage::helper('usa')->__('Invalid UPS CGI code for type %s: %s', $type, $code));
			return false;
		} else {
			return $codes[$type][$code];
		}
	}

	public function getTracking($trackings) {
		$return = array ();

		if (!is_array($trackings)) {
			$trackings = array (
			$trackings
			);
		}

		$this->_getCgiTracking($trackings);
		return $this->_result;
	}

	public function _getCgiTracking($trackings) {
		$result = Mage :: getModel('shipping/tracking_result');
		$defaults = $this->getDefaults();
		foreach ($trackings as $tracking) {
			$status = Mage :: getModel('shipping/tracking_result_status');
			$status->setCarrier($this->_getCarrierCode());
			$status->setCarrierTitle($this->getConfigData('title'));
			$status->setTracking($tracking);
			$status->setPopup(1);
			$status->setUrl($this->getConfigData('tracking_url').$tracking);
			$result->append($status);
		}

		$this->_result = $result;
		return $result;
	}

	/**
	 * Get allowed shipping methods
	 *
	 * @return array
	 */
	public function getAllowedMethods() {
		$allowed = explode(',', $this->getConfigData('allowed_methods'));
		$arr = array ();
		foreach ($allowed as $k) {
			$arr[$k] = $this->getCode('method', $k);
		}
		return $arr;
	}

	public function _doShipmentRequest(Varien_Object $request) {
		//Mage::log("_doShipmentRequest");
		// FUTURE ENHANCEMENT
	}
}