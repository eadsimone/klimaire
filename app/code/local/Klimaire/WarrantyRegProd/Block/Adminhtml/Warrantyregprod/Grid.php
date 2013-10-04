<?php

class Klimaire_WarrantyRegProd_Block_Adminhtml_Warrantyregprod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('warrantyregprodGrid');
      $this->setDefaultSort('warrantyregprod_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('warrantyregprod/warrantyregprod')->getCollection();

		/*$collection->getSelect()->joinLeft('warrantyregprod_child','main_table.warrantyregprod_id = warrantyregprod_child.warrantyregprodID', 'warrantyregprod_child.prodcode');
		echo $collection->getSelectSql();
		exit;*/
		
		//$collection->getSelect()->joinLeft('warrantyregprod_child','main_table.warrantyregprod_id = warrantyregprod_child.warrantyregprodID', 'warrantyregprod_child.prodcode')->reset(Zend_Db_Select::COLUMNS)->columns(array('main_table.fname','main_table.lname','warrantyregprod_child.prodcode','warrantyregprod_child.warrantyregprodID'));//->columns(array('main_table.warrantyregprod_id'),'dcr');
	

//$collection->getSelect()->join('warrantyregprod_child','main_table.warrantyregprod_id = warrantyregprod_child.warrantyregprodID', 'warrantyregprod_child.prodcode')->reset(Zend_Db_Select::COLUMNS)->columns(array('main_table.warrantyregprod_id','main_table.fname','main_table.lname','warrantyregprod_child.warrantyregprodID','prodcode' => new Zend_Db_Expr("IFNULL(GROUP_CONCAT(DISTINCT(`warrantyregprod_child`.`prodcode`) SEPARATOR ' , '), '')"))); //array('main_table.fname','main_table.lname','warrantyregprod_child.prodcode','warrantyregprod_child.warrantyregprodID')

//'SELECT t.*, (SELECT GROUP_CONCAT(s.prodcode) FROM warrantyregprod_child s  WHERE s.warrantyregprodID = t.warrantyregprod_id) AS combinedsolutions FROM warrantyregprod t';

//	echo $collection->getSelectSql();
//	exit;
		

// :: Final Query.... Most Important... Do Not Delete This ::
	$collection->getSelect()->reset(Zend_Db_Select::COLUMNS)->columns(array('main_table.warrantyregprod_id','main_table.email','main_table.purchasedon','main_table.installedon','main_table.created_time','main_table.update_time','main_table.status','concat(main_table.fname,\' \',main_table.lname) as fname','(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.prodcode)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = main_table.warrantyregprod_id) as prodcode','(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.serialno)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = main_table.warrantyregprod_id) as serialno','(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.indr_prodcode)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = main_table.warrantyregprod_id) as indr_prodcode','(SELECT GROUP_CONCAT(DISTINCT(warrantyregprodchild.indr_userialno)) FROM warrantyregprodchild WHERE warrantyregprodchild.warrantyregprodID = main_table.warrantyregprod_id) as indr_userialno'));
//	echo $collection->getSelectSql();
//	exit;
// :: Final Query.... Most Important... Do Not Delete This ::

     $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('warrantyregprod_id', array(
          'header'    => Mage::helper('warrantyregprod')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'warrantyregprod_id',
      ));

      /*$this->addColumn('title', array(
          'header'    => Mage::helper('warrantyregprod')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));*/
	  
	  
	  $this->addColumn('Name', array(
          'header'    => Mage::helper('warrantyregprod')->__('Name'),
          'align'     =>'left',
          'index'     => 'fname',
      ));	  


/*echo '<pre>';
print_r(get_class_methods($this));
 exit;*/

	  $this->addColumn('email', array(
          'header'    => Mage::helper('warrantyregprod')->__('Email'),
          'align'     =>'left',
          'index'     => 'email',
          'textContent'     => 'email',		  
      ));
	  

	  $this->addColumn('Product Code', array(
          'header'    => Mage::helper('warrantyregprod')->__('Product Code'),
          'align'     =>'left',
          'index'     => 'prodcode',
      ));

	  $this->addColumn('Serial No', array(
          'header'    => Mage::helper('warrantyregprod')->__('Serial No'),
          'align'     =>'left',
          'index'     => 'serialno',
      ));
	  
	  $this->addColumn('Indoor Unit Prod Code.', array(
          'header'    => Mage::helper('warrantyregprod')->__('Indoor Unit Prod Code.'),
          'align'     =>'left',
          'index'     => 'indr_prodcode',
      ));	  
	  
	  $this->addColumn('Indoor Unit Serial No.', array(
          'header'    => Mage::helper('warrantyregprod')->__('Indoor Unit Serial No.'),
          'align'     =>'left',
          'index'     => 'indr_userialno',
      ));	  

	  $this->addColumn('Purchased On', array(
          'header'    => Mage::helper('warrantyregprod')->__('Purchased On'),
          'align'     =>'left',
          'index'     => 'purchasedon',
      ));	

	  $this->addColumn('Installed On', array(
          'header'    => Mage::helper('warrantyregprod')->__('Installed On'),
          'align'     =>'left',
          'index'     => 'installedon',
      ));	

	  $this->addColumn('Registered On', array(
          'header'    => Mage::helper('warrantyregprod')->__('Registered On'),
          'align'     =>'left',
          'index'     => 'created_time',
      ));

	  $this->addColumn('Updated On', array(
          'header'    => Mage::helper('warrantyregprod')->__('Updated On'),
          'align'     =>'left',
          'index'     => 'update_time',
      ));
	
	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('warrantyregprod')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('warrantyregprod')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('warrantyregprod')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('warrantyregprod')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('warrantyregprod')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('warrantyregprod')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('warrantyregprod_id');
        $this->getMassactionBlock()->setFormFieldName('warrantyregprod');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('warrantyregprod')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('warrantyregprod')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('warrantyregprod/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('warrantyregprod')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('warrantyregprod')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}