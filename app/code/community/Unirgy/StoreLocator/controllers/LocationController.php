<?php
/**
 * Unirgy_StoreLocator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Unirgy
 * @package    Unirgy_StoreLocator
 * @copyright  Copyright (c) 2008 Unirgy LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Unirgy
 * @package    Unirgy_StoreLocator
 * @author     Boris (Moshe) Gurevich <moshe@unirgy.com>
 */
class Unirgy_StoreLocator_LocationController extends Mage_Core_Controller_Front_Action
{
    public function mapAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function searchAction()
    {
		//Mage::log('type : '.$this->getRequest()->getParam('type'));
        if($type = $this->getRequest()->getParam('type'))
			$type = explode(',',$type);
		
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        try {
            $num = (int)Mage::getStoreConfig('ustorelocator/general/num_results');
            $units = Mage::getStoreConfig('ustorelocator/general/distance_units');
            $collection = Mage::getModel('ustorelocator/location')->getCollection()
                ->addAreaFilter(
                    $this->getRequest()->getParam('lat'),
                    $this->getRequest()->getParam('lng'),
                    $this->getRequest()->getParam('radius'),
                    $this->getRequest()->getParam('units', $units)
                )
                ->addProductTypeFilter($type);

            $privateFields = Mage::getConfig()->getNode('global/ustorelocator/private_fields');
            $i = 0;
            //$klimare = Mage::helper('customer')->getKlimareProductOfInterest();
			$klimare = array(array('1-1'=>'Multi-Split','1-2'=>'Mini-Split','1-3'=>'Mini VRF'),
			array('2-1'=>'PTACK','2-2'=>'PTHP'),
			array('3-1'=>'Air Cleaners','3-2'=>'Dehudimification Systems','3-3'=>'Energy Recovery Units ER','3-4'=>'Heat Recovery Units HR'),
			array('4-1'=>'Air Conditioners','4-2'=>'Commercial VRF Systems','4-3'=>'Cooling Coils','4-4'=>'Gas Furnace','4-5'=>'Heat Pumps','4-6'=>'Package Air Conditioner','4-7'=>'Package Gas/Electric','4-8'=>'Package Heat Pump','4-9'=>'Package Water Source'));
			//$maxWell = Mage::helper('customer')->getMaxwellProductOfInterest();
			$maxWell = array('1'=>'Air Curtains','2'=>'Boiler & Heaters','3'=>'Tankless Water Heaters');
            foreach ($collection as $loc){
                $customer = Mage::getModel('customer/customer')->getCollection()
                                ->addAttributeToSelect('service_type')
                                ->addAttributeToSelect('firstname')
                                ->addAttributeToSelect('lastname')
								->addAttributeToSelect('regi_company_name')
                                ->addAttributeToSelect('customer_activated')
								->addAttributeToSelect('products_of_interest_klimaire')
								->addAttributeToSelect('products_of_interest_maxwell')
                                ->addFieldToFilter('email',$loc->getWebsiteUrl())
								//->addAttributeToFilter('products_of_interest_klimaire', array('in' => array('1-1','1-2','1-3')))
								//->addAttributeToFilter('products_of_interest_maxwell', array('in' => $Mtype))
                                ->getFirstItem();
                if(!$customer->getCustomerActivated())
                    continue;
				//Mage::log($customer->getProductsOfInterestKlimaire());
				//Mage::log($customer->getProductsOfInterestMaxwell());
                $node = $dom->createElement("marker");
                $newnode = $parnode->appendChild($node);
                $newnode->setAttribute("units", $units);
                $newnode->setAttribute("marker_label", ++$i);
                $newnode->setAttribute('customer_name',$customer->getName());
				$newnode->setAttribute('customer_company',$customer->getRegiCompanyName());
				//Mage::log($loc->getData());
                foreach ($loc->getData() as $k=>$v) {
                  if (!$privateFields->$k) {
                        if($k == 'product_types'){
                            $html = '';
                            $value = explode(',',$v);
							    
                            $klimareArr = array();
                            foreach($klimare as $_key=>$child){
                                foreach($child as $_ckey=>$childValue){
                                    if(in_array($_ckey,$value)){
                                        $klimareArr[] = $childValue;
                                    }
                                }
                            }
                            
                            $maxWellArr = array();
                            foreach($value as $curKey=>$curValue){
                                if(array_key_exists($curValue,$maxWell)){
                                    $maxWellArr[] = $maxWell[$curValue];
                                }
                            }
                            if(!empty($klimareArr)){
                                $html .= '<div class="klimare">';
                                    $html .= '<div class="title">Klimaire</div><ul>';
                                    foreach($klimareArr as $_key=>$_value){
                                        $html .= '<li>'.$_value.'</li>';
                                    }
                                $html .= '</ul></div>';
                            }
                            if(!empty($maxWellArr)){
                                $html .= '<div class="maxwell">';
                                    $html .= '<div class="title">Maxwell</div><ul>';
                                    foreach($maxWellArr as $_key=>$_value){
                                        $html .= '<li>'.$_value.'</li>';
                                    }
                                $html .= '</ul></div>';
                            }
                            //$html .= '<img src="/media/retail.png" style="width:31%; float:left;" alt="retail" />';
                            if($customer && $customer->getId()){
                                if(in_array('installation',explode(',',$customer->getServiceType())))
                                    $html .= '<img src="/media/installer.png" style="width:31%; float:left;" alt="installer" />';
								if(in_array('service',explode(',',$customer->getServiceType())))
                                    $html .= '<img src="/media/24hr.png" style="width:31%; margin-left:6px; float:left;" alt="24 hr services" />';
                                if(in_array('both',explode(',',$customer->getServiceType())))
                                    $html .= '<img src="/media/retail.png" style="width:31%; float:left;margin-left:6px;" alt="retail" />';
                            }
                            
                            $newnode->setAttribute($k, $html);
							
                        }
                        else
                            $newnode->setAttribute($k, $v);
                   }
                }
            }
			
			//print_r($loc->getData());
        } catch (Exception $e) {
            $node = $dom->createElement('error');
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute('message', $e->getMessage());
        }
        
        $this->getResponse()->setHeader('Content-Type', 'text/xml', true)->setBody($dom->saveXml());
    }
}
