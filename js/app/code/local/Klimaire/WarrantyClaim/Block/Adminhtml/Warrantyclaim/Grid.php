<?php

class Klimaire_WarrantyClaim_Block_Adminhtml_Warrantyclaim_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('warrantyclaimGrid');
      $this->setDefaultSort('warrantyclaim_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('warrantyclaim/warrantyclaim')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('warrantyclaim_id', array(
          'header'    => Mage::helper('warrantyclaim')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'warrantyclaim_id',
      ));
	  /*
      $this->addColumn('title', array(
          'header'    => Mage::helper('warrantyclaim')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));


      $this->addColumn('content', array(
			'header'    => Mage::helper('warrantyclaim')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
			  
	  $this->addColumn('reg_fname', array(
          'header'    => Mage::helper('warrantyclaim')->__('Name'),
          'align'     =>'left',
          'index'     => 'reg_fname',
      ));
	  
	  $this->addColumn('reg_email', array(
          'header'    => Mage::helper('warrantyclaim')->__('Email'),
          'align'     =>'left',
          'index'     => 'reg_email',
      ));
	  
	  $this->addColumn('confirmcode', array(
          'header'    => Mage::helper('warrantyclaim')->__('Reg/Confirm Code'),
          'align'     =>'left',
          'index'     => 'confirmcode',
      ));
	  
	  $this->addColumn('prod_code', array(
          'header'    => Mage::helper('warrantyclaim')->__('Product Code'),
          'align'     =>'left',
          'index'     => 'prod_code',
      ));

	  $this->addColumn('prod_srno', array(
          'header'    => Mage::helper('warrantyclaim')->__('Serial No'),
          'align'     =>'left',
          'index'     => 'prod_srno',
      ));	  	  
	  
	  /*$this->addColumn('prod_indr_userialno', array(
          'header'    => Mage::helper('warrantyclaim')->__('Indoor Unit Sr No'),
          'align'     =>'left',
          'index'     => 'prod_indr_userialno',
      ));*/
	  
	  
	  
	  $this->addColumn('prod_installedon', array(
          'header'    => Mage::helper('warrantyclaim')->__('Installed On'),
          'align'     =>'left',
          'index'     => 'prod_installedon',
      ));
	  
	  $this->addColumn('prod_serviceon', array(
          'header'    => Mage::helper('warrantyclaim')->__('Service On'),
          'align'     =>'left',
          'index'     => 'prod_serviceon',
      ));

	  $this->addColumn('prod_purchasedon', array(
          'header'    => Mage::helper('warrantyclaim')->__('Purchased On'),
          'align'     =>'left',
          'index'     => 'prod_purchasedon',
      ));
	  
	  $this->addColumn('created_time', array(
          'header'    => Mage::helper('warrantyclaim')->__('Created On'),
          'align'     =>'left',
          'index'     => 'created_time',
      ));
	  
	  $this->addColumn('update_time', array(
          'header'    => Mage::helper('warrantyclaim')->__('Updated On'),
          'align'     =>'left',
          'index'     => 'update_time',
      ));	  
	  	  	  

      $this->addColumn('status', array(
          'header'    => Mage::helper('warrantyclaim')->__('Status'),
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
                'header'    =>  Mage::helper('warrantyclaim')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('warrantyclaim')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('warrantyclaim')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('warrantyclaim')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('warrantyclaim_id');
        $this->getMassactionBlock()->setFormFieldName('warrantyclaim');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('warrantyclaim')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('warrantyclaim')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('warrantyclaim/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('warrantyclaim')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('warrantyclaim')->__('Status'),
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