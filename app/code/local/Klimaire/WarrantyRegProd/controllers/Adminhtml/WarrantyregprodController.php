<?php
class Klimaire_WarrantyRegProd_Adminhtml_WarrantyregprodController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('klimaire/warrantyregprod')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model = Mage::getModel('warrantyregprod/warrantyregprod')->load($id);
		

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('warrantyregprod_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('klimaire/warrantyregprod');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('warrantyregprod/adminhtml_warrantyregprod_edit'))
				->_addLeft($this->getLayout()->createBlock('warrantyregprod/adminhtml_warrantyregprod_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('warrantyregprod')->__('Warranty Product does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
		  $saveAction_id = $this->getRequest()->getParam('id');
		  $EditMode = true;	  
		  if(!isset($saveAction_id))
		  {
			$EditMode = false;
		  }
		  //echo '<pre>'; print_r($data); exit;	
		
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}

		
		if($EditMode == true)
		{
			/* **** Update/save the data to warrantyregprodchild table **** */
			if($data['child_product_info_hidden_count'] > 0)
			{
				$write_handler = Mage::getSingleton('core/resource')->getConnection('core_write');
			
				if($data['child_product_info_hidden_count'] > 0)
				{
								
				for($i=1; $i<=$data['child_product_info_hidden_count']; $i++)
				{
					try
					{
						if($data['prodtype'.$i] != '')
						{
							$query_custom_update_arr[] = "`prodtype` = '".$data['prodtype'.$i]."'";
						}
						
						if($data['prodcode'.$i] != '')
						{
							$query_custom_update_arr[] = "`prodcode` = '".$data['prodcode'.$i]."'";
						}
						
						if($data['serialno'.$i] != '')
						{
							$query_custom_update_arr[] = "`serialno` = '".$data['serialno'.$i]."'";
						}
	
						if($data['indr_prodcode'.$i] != '')
						{
							$query_custom_update_arr[] = "`indr_prodcode` = '".$data['indr_prodcode'.$i]."'";
						}
						
						if($data['indr_userialno'.$i] != '')
						{
							$query_custom_update_arr[] = "`indr_userialno` = '".$data['indr_userialno'.$i]."'";
						}
						
						if(count($query_custom_update_arr) > 0)
						{
							$query_custom_update_str = implode(',',$query_custom_update_arr);
							$query_custom_update_str .= " where `id` = ".$data['child_product_info_hidden_id'.$i];
						}
	
						/*echo $query_custom_update_str.'<pre>'; print_r($query_custom_update_arr); echo '</pre><pre>'; 
						echo '<pre>'; print_r($data); echo '</pre>'; 
						exit;*/
						
						$query_custom_update_final_str = "update warrantyregprodchild set ".$query_custom_update_str;
						$result_custom_Update = $write_handler->query($query_custom_update_final_str);
						
		            } catch (Exception $e) {						
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('warrantyregprod')->__('Error: Child Product Details Update fails'));
						$this->_redirect('*/*/');
						return;
					}

											
				}
				
				}
			}
			/* **** Update/save the data to warrantyregprodchild table **** */	
		}

	  			
		
				  			
			$model = Mage::getModel('warrantyregprod/warrantyregprod');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				//$model->getResource()->beginTransaction();				 
				//$model->save();
				

			if($EditMode == false && $data['child_product_info_hidden_count'] == 1)
			{
			
				$query_custom_insert_arr1 = array();
				$query_custom_insert_arr2 = array();			
			
					try
					{
						$write_handler = Mage::getSingleton('core/resource')->getConnection('core_write');
						
						$lastInsertId  = $write_handler->fetchOne('SELECT last_insert_id()');
						
						$query_custom_insert_arr1[] = "`warrantyregprodID`";
						$query_custom_insert_arr2[] = "'".$lastInsertId."'";
													
						if($data['prodtype1'] != '')
						{
							$query_custom_insert_arr1[] = "`prodtype`";
							$query_custom_insert_arr2[] = "'".$data['prodtype1']."'";
						}
						
						if($data['prodcode1'] != '')
						{
							$query_custom_insert_arr1[] = "`prodcode`";							
							$query_custom_insert_arr2[] = "'".$data['prodcode1']."'";
						}
						
						if($data['serialno1'] != '')
						{
							$query_custom_insert_arr1[] = "`serialno`";							
							$query_custom_insert_arr2[] = "'".$data['serialno1']."'";
						}
	
						if($data['indr_prodcode1'] != '')
						{
							$query_custom_insert_arr1[] = "`indr_prodcode`";
							$query_custom_insert_arr2[] = "'".$data['indr_prodcode1']."'";
						}
						
						if($data['indr_userialno1'] != '')
						{
							$query_custom_insert_arr1[] = "`indr_userialno`";
							$query_custom_insert_arr2[] = "'".$data['indr_userialno1']."'";
						}


						if(count($query_custom_insert_arr1) > 0 && count($query_custom_insert_arr2) > 0)
						{
							$query_custom_insert_fields = implode(',',$query_custom_insert_arr1);						
							$query_custom_insert_values = implode(',',$query_custom_insert_arr2);
						}
	
						$query_custom_insert_final_str = "insert into warrantyregprodchild1 (".$query_custom_insert_fields.") values (".$query_custom_insert_values.")";
						$result_custom_Insert = $write_handler->query($query_custom_insert_final_str);
						
		            } catch (Exception $e) {
						$model->getResource()->rollBack();						
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('warrantyregprod')->__('Error: Add new Child Product Details fails'));
						$this->_redirect('*/*/');
						return;
					}
					
				// IF child product data successfully added/saved then and then the main/parent record woud be added/saved.
				//$model->getResource()->commit();
				// IF child product data successfully added/saved then and then the main/parent record woud be added/saved.
			
			}

				$model->save();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('warrantyregprod')->__('Warranty Product Information was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('warrantyregprod')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		
		/*$data = $this->getRequest()->getParams();
		echo '<pre>'; print_r($data); exit;*/
		
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				
				$model = Mage::getModel('warrantyregprod/warrantyregprod');				 
				//$model->getResource()->beginTransaction();				 
				$model->setId($this->getRequest()->getParam('id'))->delete();
					
				// Child Product info delete ****** //	
				try {				
					$write_handler = Mage::getSingleton('core/resource')->getConnection('core_write');					 
					$query_custom_delete_childProd = "delete from warrantyregprodchild where warrantyregprodID = '".$this->getRequest()->getParam('id')."'";
					$result_custom_delete_childProd = $write_handler->query($query_custom_delete_childProd);
				
				}				
				catch (Exception $e) {
					
					//$model->getResource()->rollBack();
					
					Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
					$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));	
					return;					
				}
				// Child Product info delete ****** //					
				
				
				// IF child product data successfully deleted then and then the main/parent record woud be deleted.
				//$model->getResource()->commit();
				// IF child product data successfully deleted then and then the main/parent record woud be deleted.
														 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Warranty Product was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $warrantyregprodIds = $this->getRequest()->getParam('warrantyregprod');
        if(!is_array($warrantyregprodIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Warranty Product(s)'));
        } else {
            try {
                foreach ($warrantyregprodIds as $warrantyregprodId) {
                    
					$warrantyregprod = Mage::getModel('warrantyregprod/warrantyregprod')->load($warrantyregprodId);					
					//$warrantyregprod->getResource()->beginTransaction();
                    $warrantyregprod->delete();					
					
				// Child Product info delete ****** //	
				try {				
					$write_handler = Mage::getSingleton('core/resource')->getConnection('core_write');					 
					$query_custom_delete_childProd = "delete from warrantyregprodchild where warrantyregprodID = '".$warrantyregprodId."'";
					$result_custom_delete_childProd = $write_handler->query($query_custom_delete_childProd);
				
				}				
				catch (Exception $e) {					
					//$warrantyregprod->getResource()->rollBack();
	                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			        $this->_redirect('*/*/index');
					return;							
				}
				// Child Product info delete ****** //					
				
				
				// IF child product data successfully deleted then and then the main/parent record woud be deleted.
				//$warrantyregprod->getResource()->commit();
				// IF child product data successfully deleted then and then the main/parent record woud be deleted.
									
					

                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d Warranty Product(s) were successfully deleted', count($warrantyregprodIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $warrantyregprodIds = $this->getRequest()->getParam('warrantyregprod');
        if(!is_array($warrantyregprodIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($warrantyregprodIds as $warrantyregprodId) {
                    $warrantyregprod = Mage::getSingleton('warrantyregprod/warrantyregprod')
                        ->load($warrantyregprodId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d Warranty Product(s) were successfully updated', count($warrantyregprodIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'warrantyregprod.csv';
        $content    = $this->getLayout()->createBlock('warrantyregprod/adminhtml_warrantyregprod_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'warrantyregprod.xml';
        $content    = $this->getLayout()->createBlock('warrantyregprod/adminhtml_warrantyregprod_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}