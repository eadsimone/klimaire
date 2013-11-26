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
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Sales Order Shipment Pdf default items renderer
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Model_Order_Pdf_Items_Shipment_Default extends Mage_Sales_Model_Order_Pdf_Items_Abstract
{
    /**
     * Draw item line
     */
    public function draw()
    {
        $item   = $this->getItem();
        $pdf    = $this->getPdf();
        $page   = $this->getPage();
        $lines  = array();
		$lines2 = array();
		$Currenproduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$this->getSku($item));
		$attributeValue1 = ($Currenproduct->getAttributeText('qtytoship')*1)*($item->getQty()*1);
		$attributeValue2 = ($Currenproduct->getAttributeText('qtyoship')*1)*($item->getQty()*1);
		$attributeValue3 = ($Currenproduct->getAttributeText('qtyinstallship')*1)*($item->getQty()*1);
		
        // draw Product name
        $lines[0] = array(array(
            'text' => Mage::helper('core/string')->str_split($item->getName(), 60, true, true),
            'feed' => 100
        ));
		
		
		// draw Product Description
        $lines2[0]= array(array(
           'text' => Mage::helper('core/string')->str_split(strip_tags(trim($Currenproduct->getDescription())), 50,true,true),
            'feed' => 225
        ));
		
        // draw QTY
        $lines[0][] = array(
            //'text'  => ($item->getQty()*1).' test',
			'text'  => $attributeValue1,
            'feed'  => 35
        );

        // draw SKU
        $lines[0][] = array(
            'text'  => Mage::helper('core/string')->str_split($this->getSku($item), 25),
            'feed'  => 507,
            'align' => 'left'
        );
		
		if($attributeValue2 > 1 || $attributeValue2 != '')
		{			
			$pos = strpos($item->getName(), '-I');
			if($pos == false )
			{
				$prod_o = Mage::helper('core/string')->str_split($item->getName(), 60, true, true);
			}
			else
			{
				$option_o = str_replace('-I','-O',$item->getName());
				$prod_o = Mage::helper('core/string')->str_split($option_o, 60, true, true);
			}
		}
		else
		{
			$prod_o = '';	
		}

		
		$lines3[0]= array(array(
		   'text' => $prod_o,
		   'feed' => 100
		));
		//getting outdoor unit model name and product detail;				
		$prd = Mage::getModel('catalog/product')->loadByAttribute('sku',$prod_o[0]);
		if($prd){
			$lines3[0][] = array(
				'text'  => Mage::helper('core/string')->str_split(strip_tags(trim($prd->getDescription())), 50,true,true),
				'feed'  => 225
			);
			$lines3[0][] = array(
				'text'  => Mage::helper('core/string')->str_split($prd->getSku(), 17),
				'feed'  => 507,
				'align' => 'left'
			);
		}
			
		$lines3[0][] = array(
			//'text'  => ($item->getQty()*1).' test',
			'text'  => $attributeValue2,
			'feed'  => 35
		);

		if($attributeValue3 > 1 || $attributeValue3 != '')
		{			
			$inst_kits = Mage::helper('core/string')->str_split('Installation Kits', 60, true, true);
		}
		else
		{
			$inst_kits = '';	
		}
		
		$lines4[0]= array(array(
			'text' => $inst_kits,
			'feed' => 100
		));
		
		$lines4[0][] = array(
			//'text'  => ($item->getQty()*1).' test',
			'text'  => $attributeValue3,
			'feed'  => 35
		);

		
        // Custom options
        $options = $this->getItemOptions();
        if ($options) {
            foreach ($options as $option) {
                // draw options label
                $lines[][] = array(
                    'text' => Mage::helper('core/string')->str_split(strip_tags($option['label']), 70, true, true),
                    'font' => 'italic',
                    'feed' => 110
                );
				
				$lines3[][] = array(
                    'text' => Mage::helper('core/string')->str_split(strip_tags($option['label']), 70, true, true),
                    'font' => 'italic',
                    'feed' => 110
                );
				
				$lines4[][] = array(
                    'text' => Mage::helper('core/string')->str_split(strip_tags($option['label']), 70, true, true),
                    'font' => 'italic',
                    'feed' => 110
                );

                // draw options value
                if ($option['value']) {
                    $_printValue = isset($option['print_value'])
                        ? $option['print_value']
                        : strip_tags($option['value']);
                    $values = explode(', ', $_printValue);
					foreach ($values as $value) {
	                    
					    $lines[][] = array(
                            'text' => Mage::helper('core/string')->str_split($value, 50, true, true),
                            'feed' => 115
                        );
						$lines3[][] = array(
                            'text' => Mage::helper('core/string')->str_split($value, 50, true, true),
                            'feed' => 115
                        );
						$lines4[][] = array(
                            'text' => Mage::helper('core/string')->str_split($value, 50, true, true),
                            'feed' => 115
                        );
                    }
                }
            }
        }

        $lineBlock = array(
            'lines'  => $lines,
            'height' => 0
        );
		
		$lineBlock2 = array(
            'lines'  => $lines2,
            'height' => 12
        );
		
		$lineBlock3 = array(
            'lines'  => $lines3,
            'height' => 12
        );
	$lineBlock4 = array(
            'lines'  => $lines4,
            'height' => 12
        );

        $page = $pdf->drawLineBlocks($page, array($lineBlock), array('table_header' => true));
		$page = $pdf->drawLineBlocks($page, array($lineBlock2), array('table_header' => true));
		$page = $pdf->drawLineBlocks($page, array($lineBlock3), array('table_header' => true));
		$page = $pdf->drawLineBlocks($page, array($lineBlock4), array('table_header' => true));
        $this->setPage($page);
    }
}
