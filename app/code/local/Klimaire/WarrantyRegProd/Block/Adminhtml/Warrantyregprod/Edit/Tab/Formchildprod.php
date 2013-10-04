<?php

class Klimaire_WarrantyRegProd_Block_Adminhtml_Warrantyregprod_Edit_Tab_Formchildprod extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('warrantyregprod_form', array('legend'=>Mage::helper('warrantyregprod')->__('Product-Child info.')));

	  $id = $this->getRequest()->getParam('id');
	  $EditMode = true;	  
	  if(!isset($id))
	  {
		$EditMode = false;
	  }
	  
	  $model  = Mage::getModel('warrantyregprod/warrantyregprodchild')->getCollection();
	  $model->addFilter('warrantyregprodID',$id); 
	  
	  $cnt = 1;
	  foreach($model->getData() as $obj)
	  {

		if($cnt == 1)
		{
		  $collection_final = Mage::getModel('warrantyregprod/warrantyregprodchild')->load($obj['id']);

		  foreach($collection_final as $tmp_coll_obj)
		  {			  
	   	  	  $tmp_coll_obj['child_product_info_hidden_id'.$cnt] = $collection_final->getId();
      	  	  $tmp_coll_obj['prodtype'.$cnt] = $collection_final->getProdtype();
    	  	  $tmp_coll_obj['prodcode'.$cnt] = $collection_final->getProdcode();			  
			  $tmp_coll_obj['serialno'.$cnt] = $collection_final->getSerialno();
			  $tmp_coll_obj['indr_prodcode'.$cnt] = $collection_final->getIndr_prodcode();
		  	  $tmp_coll_obj['indr_userialno'.$cnt] = $collection_final->getIndr_userialno();			  
		  	  $tmp_coll_obj['child_product_info_hidden_count'] = 1;
			  $collection_final->addData($tmp_coll_obj);
			  break;
		  }


		}
		else
		{
		  $collection = Mage::getModel('warrantyregprod/warrantyregprodchild')->load($obj['id']);
		  $_arr['collection'.$cnt] = $collection;			
		}
		
  	  $cnt++;

	  }
	  


	  $cnt = 2;	  
	  foreach($_arr as $coll_obj)
	  {
		foreach ($coll_obj as $item){
   	  	  $item['child_product_info_hidden_id'.$cnt] = $coll_obj->getId();			
   	  	  $item['prodtype'.$cnt] = $coll_obj->getProdtype();
   	  	  $item['prodcode'.$cnt] = $coll_obj->getProdcode();			  
		  $item['serialno'.$cnt] = $coll_obj->getSerialno();
		  $item['indr_prodcode'.$cnt] = $coll_obj->getIndr_prodcode();
	  	  $item['indr_userialno'.$cnt] = $coll_obj->getIndr_userialno();
	  	  $item['child_product_info_hidden_count'] = $cnt;
		
			$collection_final->addData($item);
		}

		  $cnt++;
	  }
		/*echo '<pre>';
		print_r($collection_final); exit;*/
		
		if($EditMode == true)
		{
			Mage::register('warrantyregprodchild_data', $collection_final);
		}
		
$collection_cnt = count($_arr)+1;
for($i=1; $i<=$collection_cnt; $i++)
{
	
		  
		$fieldset->addField('prodtype'.$i, 'select', array(
          'label'     => Mage::helper('warrantyregprod')->__('Product Type'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'prodtype'.$i,
          'note'      => 'Assumed to be Product '.$i.' INFO ',	
		  'values'    => array(
									  array(
										  'value'     => 'residential',
										  'label'     => Mage::helper('warrantyregprod')->__('Residential'),
									  ),
						
									  array(
										  'value'     => 'commercial',
										  'label'     => Mage::helper('warrantyregprod')->__('Commercial'),
									  ),
								  )	  
      ));
	  
		$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
		$_qur = "select prodcode from warrantyclientdb group by prodcode";
		$_res = $read_handler->query($_qur);
		$coll = $_res->fetchAll();
		
		$prod_arr = array(''=>'Select Product');
		foreach($coll as $prod)
		{
			$prod_arr[trim($prod['prodcode'])] = trim($prod['prodcode']);
		}		
				  
	  
		$fieldset->addField('prodcode'.$i, 'select', array(
          'label'     => Mage::helper('warrantyregprod')->__('Product Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'prodcode'.$i,
          'note'      => 'Assumed to be Product '.$i.' INFO ',		
		  'values'    => $prod_arr,		    		  
      ));

echo "virendra";
      $fieldset->addField('serialno'.$i, 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Serial No.'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'serialno'.$i,
          'note'      => 'Assumed to be Product '.$i.' INFO ',		  		  
      ));
	  echo "end virendra";
		$fieldset->addField('indr_prodcode'.$i, 'select', array(
          'label'     => Mage::helper('warrantyregprod')->__('Indoor Unit Prod Code.'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'indr_prodcode'.$i,
          'note'      => 'Assumed to be Product '.$i.' INFO ',
		  'values'    => $prod_arr,			  		  		  
      ));

      $fieldset->addField('indr_userialno'.$i, 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Indoor Unit Serial No.'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'indr_userialno'.$i,
          'note'      => 'Assumed to be Product '.$i.' INFO ',		  		  
      ));	  


      $fieldset->addField('child_product_info_hidden_id'.$i, 'hidden', array(
          'name'      => 'child_product_info_hidden_id'.$i,
      ));
	  
}

      $fieldset->addField('child_product_info_hidden_count', 'hidden', array(
          'name'      => 'child_product_info_hidden_count',
		  'value'    => $collection_cnt,
      ));
	  

      //var_dump(Mage::registry('warrantyregprodchild_data')->getData()); exit;

/*
  	  print_r(get_class($fieldset));
	  echo '<br><br>';
	  print_r(get_class_methods($fieldset));
	  exit;*/

	  /*$read_handler = Mage::getSingleton('core/resource')->getConnection('core_read');
	  $_qur = "select * from warrantyregprod_child where warrantyregprodID = '".$this->getRequest()->getParam('id')."'";
	  $_res = $read_handler->query($_qur);
	  $coll = $_res->fetchAll();*/


	 
      
	  
      /*$fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('warrantyregprod')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));*/

	
/*foreach($coll as $sdfljf)
{
$fieldset->addField($sdfljf['id'], 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer Dealer Name'),
          'class'     => 'required-entry',
          'name'      => 'prodcode',
		  'note'     => $sdfljf['prodcode'],
          'value'  => $sdfljf['prodcode'],
          'required'  => true,
		  
      ));
}*/
/*
$fieldset->addField('inst_licenseno', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer License Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_licenseno',
      ));	

$fieldset->addField('inst_dealer_street', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer Dealer Street Address'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_dealer_street',
      ));

$fieldset->addField('inst_dealer_ph', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer Phone Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_dealer_ph',
      ));

$fieldset->addField('dealer_phno', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Dealer Phone Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'dealer_phno',
      ));

$fieldset->addField('inst_city', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_city',
      ));

$fieldset->addField('inst_state', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('State'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_state',
      ));

$fieldset->addField('inst_zip', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Zip'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_zip',
      ));

$fieldset->addField('inst_dealer_phno', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Installer Dealer Phone Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'inst_dealer_phno',
      ));

$fieldset->addField('confirmcode', 'text', array(
          'label'     => Mage::helper('warrantyregprod')->__('Registration Confirmation Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'confirmcode',
      ));

		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('warrantyregprod')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('warrantyregprod')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('warrantyregprod')->__('Disabled'),
              ),
          ),
      ));*/
     
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('warrantyregprod')->__('Content'),
          'title'     => Mage::helper('warrantyregprod')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
	  //var_dump(Mage::registry('warrantyregprodchild_data')); exit;
	  if ( Mage::getSingleton('adminhtml/session')->getWarrantyRegProdChildData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getWarrantyRegProdChildData());
          Mage::getSingleton('adminhtml/session')->setWarrantyRegProdChildData(null);
      } elseif (Mage::registry('warrantyregprodchild_data')) {
          $form->setValues(Mage::registry('warrantyregprodchild_data')->getData());
      }	  
	  
      return parent::_prepareForm();
  }
}