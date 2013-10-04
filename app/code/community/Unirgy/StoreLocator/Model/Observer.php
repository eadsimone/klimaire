<?php
class Unirgy_StoreLocator_Model_Observer
{
    public function addLocation($observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        try{
            $storeLocation = Mage::getModel('ustorelocator/location')->getCollection()
                                    ->getItemByColumnValue('website_url',$customer->getEmail());
            if($customer->getRegiBusinessType() && $customer->getRegiAddress() && $customer->getRegiCity() && $customer->getRegiState() && $customer->getRegiZip() && $customer->getRegiTitle()){
                    $productType = array();
                    
                    if(!$storeLocation){
                        $storeLocation = Mage::getModel('ustorelocator/location');
                        $storeLocation->setId(null);
                    }
                    $address = $customer->getRegiAddress().",\n".$customer->getRegiCity().', '.$customer->getRegiState().' '.$customer->getRegiZip();
                    $storeLocation  ->setTitle($customer->getRegiTitle())
                                    ->setWebsiteUrl($customer->getEmail())
                                    ->setAddressDisplay($address);
                    if($customer->getRegiPhone() || $customer->getRegiMobile()){
                        $phone = $customer->getRegiPhone();
                        if(!$phone)
                            $phone = $customer->getRegiMobile();
                        $storeLocation->setPhone($phone);
                    }
                    $storeLocation->save();
                
            }
            if($storeLocation){
                $productType = array();
                if($customer->getProductsOfInterestKlimaire()){
                    $productType = explode(',',$customer->getProductsOfInterestKlimaire());
                }
               
                if($customer->getProductsOfInterestMaxwell()){
                    
                    $productType = array_merge($productType,explode(',',$customer->getProductsOfInterestMaxwell()));
                }
                
                if(!empty($productType)){
                    $storeLocation->setProductTypes(implode(',',$productType));
                }
                else
                    $storeLocation->setProductTypes('');
                $storeLocation->save();
            }
        } catch (Mage_Core_Exception $e) {
            Mage::throwException($e->getMessage());
        } catch (Exception $e) {
            Mage::throwException($e->getMessage());
        }
        return $this;
    }
    public function removeLocation($observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $email = $customer->getEmail();
        $location = Mage::getModel('ustorelocator/location')->getCollection()
                    ->getItemByColumnValue('website_url',$email);
        if($location && $location->getId())
            $location->delete();
    }
}    
