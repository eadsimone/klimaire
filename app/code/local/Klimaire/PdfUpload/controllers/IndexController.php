<?php
class Klimaire_PdfUpload_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/pdfupload?id=15 
    	 *  or
    	 * http://site.com/pdfupload/id/15 	
    	 */
    	/* 
		$pdfupload_id = $this->getRequest()->getParam('id');

  		if($pdfupload_id != null && $pdfupload_id != '')	{
			$pdfupload = Mage::getModel('pdfupload/pdfupload')->load($pdfupload_id)->getData();
		} else {
			$pdfupload = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($pdfupload == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$pdfuploadTable = $resource->getTableName('pdfupload');
			
			$select = $read->select()
			   ->from($pdfuploadTable,array('pdfupload_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$pdfupload = $read->fetchRow($select);
		}
		Mage::register('pdfupload', $pdfupload);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}