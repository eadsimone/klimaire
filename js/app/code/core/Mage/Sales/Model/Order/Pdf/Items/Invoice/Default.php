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
 * Sales Order Invoice Pdf default items renderer
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Model_Order_Pdf_Items_Invoice_Default extends Mage_Sales_Model_Order_Pdf_Items_Abstract
{
    /**
     * Draw item line
     */
    public function draw()
    {
        $order  = $this->getOrder();
        $item   = $this->getItem();
        $pdf    = $this->getPdf();
        $page   = $this->getPage();
        $lines  = array();
		
	$Currenproduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$this->getSku($item));
	$attributeValue1 = ($Currenproduct->getAttributeText('qtytoship')*1)*($item->getQty()*1);
	$attributeValue2 = ($Currenproduct->getAttributeText('qtyoship')*1)*($item->getQty()*1);
	$attributeValue3 = ($Currenproduct->getAttributeText('qtyinstallship')*1)*($item->getQty()*1);

        // draw Product name
        $lines[0] = array(array(
            'text' => Mage::helper('core/string')->str_split($item->getName(), 35, true, true),
            'feed' => 35,
        ));

	// draw Description
	$lines[0][] = array(
            'text'  => Mage::helper('core/string')->str_split(strip_tags(trim($Currenproduct->getDescription())), 46,true,true),
            'feed'  => 125,
            'align' => 'justify'
        );
        // draw SKU
        $lines[0][] = array(
            'text'  => Mage::helper('core/string')->str_split($this->getSku($item), 17),
            'feed'  => 340,
            'align' => 'left'
        );
		
		
		if($attributeValue2 > 1 || $attributeValue2 != '')
		{			
			$pos = strpos($item->getName(), '-I');
			if($pos == false )
			{
				$prod_o = Mage::helper('core/string')->str_split($item->getName(), 35, true, true);
			}
			else
			{
				$option_o = str_replace('-I','-O',$item->getName());
				$prod_o = Mage::helper('core/string')->str_split($option_o, 35, true, true);
			}
			
		}
		else
		{
			$prod_o = '';	
		}
		
		$lines3[0]= array(array(
		   'text' => $prod_o,
		   'feed' => 35
		));
		//getting outdoor unit model name and product detail;				
		$prd = Mage::getModel('catalog/product')->loadByAttribute('sku',$prod_o[0]);
		if($prd){
			$lines3[0][] = array(
				'text'  => Mage::helper('core/string')->str_split(strip_tags(trim($prd->getDescription())), 46,true,true),
				'feed'  => 125,
				'align' => 'justify'
			);
			$lines3[0][] = array(
				'text'  => Mage::helper('core/string')->str_split($prd->getSku(), 17),
				'feed'  => 340,
				'align' => 'left'
			);
		}
		$lines3[0][] = array(
			//'text'  => ($item->getQty()*1).' test',
			'text'  => $attributeValue2,
			'feed'  => 490,
            		'align' => 'left'
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
			'feed' => 35
		));
		
		$lines4[0][] = array(
			//'text'  => ($item->getQty()*1).' test',
			'text'  => $attributeValue3,
			'feed'  => 490,
            		'align' => 'left'
		);

		

        // draw QTY
		
	$lines[0][] = array(
            'text'  => $attributeValue1,
            'feed'  => 495,
            'align' => 'right'
        );
		
        /*$lines[0][] = array(
            'text'  => $item->getQty() * 1,
            'feed'  => 435,
            'align' => 'right'
        );*/

        // draw item Prices
        $i = 0;
        $prices = $this->getItemPricesForDisplay();
        $feedPrice = 425;
        $feedSubtotal = 565;
        foreach ($prices as $priceData){
            if (isset($priceData['label'])) {
                // draw Price label
                $lines[$i][] = array(
                    'text'  => $priceData['label'],
                    'feed'  => $feedPrice,
                    'align' => 'left'
                );
                // draw Subtotal label
                $lines[$i][] = array(
                    'text'  => $priceData['label'],
                    'feed'  => $feedSubtotal,
                    'align' => 'right'
                );
                $i++;
            }
            // draw Price
            $lines[$i][] = array(
                'text'  => $priceData['price'],
                'feed'  => $feedPrice,
                'font'  => 'bold',
                'align' => 'left'
            );
            // draw Subtotal
            $lines[$i][] = array(
                'text'  => $priceData['subtotal'],
                'feed'  => $feedSubtotal,
                'font'  => 'bold',
                'align' => 'right'
            );
            $i++;
        }

        // draw Tax
        /*$lines[0][] = array(
            'text'  => $order->formatPriceTxt($item->getTaxAmount()),
            'feed'  => 495,
            'font'  => 'bold',
            'align' => 'right'
        );
	*/
        // custom options
        $options = $this->getItemOptions();
        if ($options) {
            foreach ($options as $option) {
                // draw options label
                $lines[][] = array(
                    'text' => Mage::helper('core/string')->str_split(strip_tags($option['label']), 40, true, true),
                    'font' => 'italic',
                    'feed' => 35
                );
				
				$lines3[][] = array(
                    'text' => Mage::helper('core/string')->str_split(strip_tags($option['label']), 40, true, true),
                    'font' => 'italic',
                    'feed' => 35
                );
				
				$lines4[][] = array(
                    'text' => Mage::helper('core/string')->str_split(strip_tags($option['label']), 40, true, true),
                    'font' => 'italic',
                    'feed' => 35
                );

                if ($option['value']) {
                    if (isset($option['print_value'])) {
                        $_printValue = $option['print_value'];
                    } else {
                        $_printValue = strip_tags($option['value']);
                    }
                    $values = explode(', ', $_printValue);
                    foreach ($values as $value) {
                        $lines[][] = array(
                            'text' => Mage::helper('core/string')->str_split($value, 30, true, true),
                            'feed' => 40
                        );
						$lines3[][] = array(
                            'text' => Mage::helper('core/string')->str_split($value, 30, true, true),
                            'feed' => 40
                        );
						$lines4[][] = array(
                            'text' => Mage::helper('core/string')->str_split($value, 30, true, true),
                            'feed' => 40
                        );
                    }
                }
            }
        }

        $lineBlock = array(
            'lines'  => $lines,
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
	$page = $pdf->drawLineBlocks($page, array($lineBlock3), array('table_header' => true));
	$page = $pdf->drawLineBlocks($page, array($lineBlock4), array('table_header' => true));
        $this->setPage($page);
    }
}
