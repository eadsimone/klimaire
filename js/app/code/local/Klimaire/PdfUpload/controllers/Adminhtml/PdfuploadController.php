<?php

class Klimaire_PdfUpload_Adminhtml_PdfuploadController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('klimaire/pdfupload')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('pdfupload/pdfupload')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
					//$model = Mage::getModel('pdfupload/pdfupload')->load($id)->addData($data);
					$data['product_id']=implode(',',$this->getRequest()->getPost('product_id')); 
					$data['tab_id']=$this->getRequest()->getPost('tab_id'); 
	  			//var_dump($data['product_id']);
				//exit;
				$model->setData($data);
			}

			Mage::register('pdfupload_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('klimaire/pdfupload');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('pdfupload/adminhtml_pdfupload_edit'))
				->_addLeft($this->getLayout()->createBlock('pdfupload/adminhtml_pdfupload_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pdfupload')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
		$getId_edit = $this->getRequest()->getParam('id');	
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('pdf','PDF')); //'jpg','jpeg','gif','png'
					$uploader->setAllowRenameFiles(false);
					
					$Allowed_FileType_arr  = array('pdf','PDF','application/pdf','application/PDF');
					if(!in_array($_FILES['filename']['type'],$Allowed_FileType_arr))
					{
						Mage::getSingleton('adminhtml/session')->addError("Sorry, File type does not allowed.");
						// set Redirection based on edit/add action
						if(isset($getId_edit))
						{
							$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
						}
						else
						{
							$this->_redirect('*/*/');
						}
						// set Redirection based on edit/add action
						return;	
					}
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS .'klimaire_product_pdfs/';
					$pdf_FileName_toUpload = uniqid().'_-_'.$_FILES['filename']['name'];
					$uploader->save($path,  $pdf_FileName_toUpload);
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $pdf_FileName_toUpload;
				$data['filename_disp'] = $_FILES['filename']['name']; 
				
			 	}


			//$data['product_id']= $this->getRequest()->getPost('product_id');
			$data['tab_id']=$this->getRequest()->getPost('tab_id'); 
			
			$data['product_id']=implode(',',$this->getRequest()->getPost('product_id')); 
	  			//var_dump($data);
//				exit;
			$model = Mage::getModel('pdfupload/pdfupload');		
			
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
				
				
			
			try {
					// set created & Updated time based on edit/add action
					if(isset($getId_edit))
					{
						$model->setUpdateTime(now());
					}
					else
					{
						$model->setCreatedTime(now())
						->setUpdateTime(now());
					}
					
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pdfupload')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pdfupload')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('pdfupload/pdfupload');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $pdfuploadIds = $this->getRequest()->getParam('pdfupload');
        if(!is_array($pdfuploadIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($pdfuploadIds as $pdfuploadId) {
                    $pdfupload = Mage::getModel('pdfupload/pdfupload')->load($pdfuploadId);
                    $pdfupload->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($pdfuploadIds)
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
        $pdfuploadIds = $this->getRequest()->getParam('pdfupload');
        if(!is_array($pdfuploadIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($pdfuploadIds as $pdfuploadId) {
                    $pdfupload = Mage::getSingleton('pdfupload/pdfupload')
                        ->load($pdfuploadId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($pdfuploadIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'pdfupload.csv';
        $content    = $this->getLayout()->createBlock('pdfupload/adminhtml_pdfupload_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'pdfupload.xml';
        $content    = $this->getLayout()->createBlock('pdfupload/adminhtml_pdfupload_grid')
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