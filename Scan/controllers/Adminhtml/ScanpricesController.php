<?php

class Bms_Scan_Adminhtml_ScanpricesController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('scan/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('scan/scanprices')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('scanprices_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('scan/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('scan/adminhtml_scanprices_edit'))
				->_addLeft($this->getLayout()->createBlock('scan/adminhtml_scanprices_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('scan')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
	  		

			$currentTimestamp = Mage::getModel('core/date')->timestamp(time());
			$currentDate = date('Y-m-d H:i:s', $currentTimestamp);
			
			$aruser = Mage::getSingleton('admin/session');
	        $aruserId = $aruser->getUser()->getUsername();
			
			$model = Mage::getModel('scan/scanprices');		
			$model->setData($data)->setUpdatedBy($aruserId)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedAt == NULL) {
					$model->setCreatedAt($currentDate);
						
				} 
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('scan')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('scan')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('scan/scanprices');
				 
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
        $scanIds = $this->getRequest()->getParam('scan');
        if(!is_array($scanIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($scanIds as $scanId) {
                    $scan = Mage::getModel('scan/scanprices')->load($scanId);
                    $scan->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($scanIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    // public function massStatusAction()
    // {
        // $scanIds = $this->getRequest()->getParam('scan');
        // if(!is_array($scanIds)) {
            // Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        // } else {
            // try {
                // foreach ($scanIds as $scanId) {
                    // $scan = Mage::getSingleton('scan/scan')
                        // ->load($scanId)
                        // ->setStatus($this->getRequest()->getParam('status'))
                        // ->setIsMassupdate(true)
                        // ->save();
                // }
                // $this->_getSession()->addSuccess(
                    // $this->__('Total of %d record(s) were successfully updated', count($scanIds))
                // );
            // } catch (Exception $e) {
                // $this->_getSession()->addError($e->getMessage());
            // }
        // }
        // $this->_redirect('*/*/index');
    // }
	
	protected function _isAllowed()  
	{  
   		return true;  
	}
  
    public function exportCsvAction()
    {
        $fileName   = 'scanhospital.csv';
        $content    = $this->getLayout()->createBlock('scan/adminhtml_scanprices_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    // public function exportXmlAction()
    // {
        // $fileName   = 'scan.xml';
        // $content    = $this->getLayout()->createBlock('scan/adminhtml_scan_grid')
            // ->getXml();

        // $this->_sendUploadResponse($fileName, $content);
    // }

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