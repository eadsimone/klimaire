<?php
class EM_FlexibleWidget_Block_Special extends Mage_Catalog_Block_Product
{
    public function getProductSpecialPrice()
    {
        $collections = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter(array(
                                array(
                                
                                        'attribute' => 'special_price',
                                
                                        'gt'        => array(0),
                                
                                        ),
                                    )
                                );
                                echo count($collections);
        foreach($collections as $c)
        {
            print_r($c->getData());
        }
                                //print_r($collections);
                                exit('abc');
    }
}

?>