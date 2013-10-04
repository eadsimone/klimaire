<?php

class Klimaire_PdfUpload_Block_Adminhtml_Pdfupload_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('pdfuploadGrid');
      $this->setDefaultSort('pdfupload_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('pdfupload/pdfupload')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('pdfupload_id', array(
          'header'    => Mage::helper('pdfupload')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'pdfupload_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('pdfupload')->__('Title'),
          'align'     =>'left',
		  'width'     => '150px',
          'index'     => 'title',
      ));

	  
      $this->addColumn('filename_disp', array(
			'header'    => Mage::helper('pdfupload')->__('PDF File Name'),
			'width'     => '150px',
			'index'     => 'filename_disp',
      ));
	  

      $this->addColumn('status', array(
          'header'    => Mage::helper('pdfupload')->__('Status'),
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
                'header'    =>  Mage::helper('pdfupload')->__('Action'),
                'width'     => '50',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('pdfupload')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('pdfupload')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('pdfupload')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('pdfupload_id');
        $this->getMassactionBlock()->setFormFieldName('pdfupload');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('pdfupload')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('pdfupload')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('pdfupload/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('pdfupload')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('pdfupload')->__('Status'),
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