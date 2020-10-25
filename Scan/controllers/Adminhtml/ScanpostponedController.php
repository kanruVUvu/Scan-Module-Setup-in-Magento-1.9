<?php

class Bms_Scan_Adminhtml_ScanpostponedController extends Mage_Adminhtml_Controller_action
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
		$model  = Mage::getModel('scan/scancrm')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('scanpostponed_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('scan/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('scan/adminhtml_scanpostponed_edit'))
				->_addLeft($this->getLayout()->createBlock('scan/adminhtml_scanpostponed_edit_tabs'));

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
			
			if($data['leadowner']==""){
				$aruser = Mage::getSingleton('admin/session');
	        	$aruserId = $aruser->getUser()->getUsername();
				$data['leadowner']=$aruserId;
				
				$then = new DateTime($data['created_time']);
				$now = new DateTime($currentDate);
				$sinceThen = $then->diff($now);
			    //echo $sinceThen->format('%y years %m months %a days %h:%i:%s seconds');;
				$attend=$sinceThen->format('%h:%i:%s');
				$data['attend_time']=$attend;
			}
			
			$model = Mage::getModel('scan/scancrm');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					//$model->setCreatedTime(now())
					$model->setUpdateTime($currentDate);
				} else {
					$model->setUpdateTime($currentDate);
				}	
				
				$model->save();

				if($data['status']==4){
					$status="Rejected";
				}
				else if($data['status']==2){
					$status="Confirmed";
					if ($data['confirm_sms'] == 1) {
						$this->sendcustomerSms($data);	
					}
					if ($data['confirm_email'] == 1) {
						$this->sendconfirmMail($data);	
					}
				}
				else if($data['status']==6){
					$status="RNR";
				}
				else{
					$status="Postponed";
				}
				
				if($data['sendrnrsms']==1){
                    $helper = Mage::helper('blogchat');
                    $resval=$helper->sendRnrSms($data);
                }

				$aruser = Mage::getSingleton('admin/session');
        		$aruserId = $aruser->getUser()->getUsername();

        		$currentTimestamp = Mage::getModel('core/date')->timestamp(time()); //Magento's timestamp function makes a usage of timezone and converts it to timestamp
        		$date = date('Y-m-d H:i:s', $currentTimestamp); //The value may differ than above because of the timezone settings.

				$history = Mage::getSingleton('core/resource')->getConnection('core_write');
        		$history->insert(
                	"bs_historymap", array("cid" => $this->getRequest()->getParam('id'), "coupon_code" => $data['bmsbooking_code'], "name" => $data['name'], "updated_by" => $aruserId, "time" =>$date, "status" =>$status ,"follow_comments"=> $data['feedback'],"enq_type"=>"scan")
        		);

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
				$model = Mage::getModel('scan/scancrm');
				 
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
        $scanIds = $this->getRequest()->getParam('scancrm');
        if(!is_array($scanIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($scanIds as $scanId) {
                    $scan = Mage::getModel('scan/scancrm')->load($scanId);
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
	
    public function massStatusAction()
    {
        $scanIds = $this->getRequest()->getParam('scan');
        if(!is_array($scanIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($scanIds as $scanId) {
                    $scan = Mage::getSingleton('scan/scan')
                        ->load($scanId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($scanIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'scanpostponed.csv';
        $content    = $this->getLayout()->createBlock('scan/adminhtml_scanpostponed_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }
	
	protected function _isAllowed()  
	{  
   		return true;  
	}
	
    // public function exportXmlAction()
    // {
    //     $fileName   = 'surgery.xml';
    //     $content    = $this->getLayout()->createBlock('surgery/adminhtml_surgery_grid')
    //         ->getXml();

    //     $this->_sendUploadResponse($fileName, $content);
    // }
	
	
	 public function sendcustomerSms($data){
        try {
			
            $modelH = Mage::getModel('scan/scanhospital')->load($data['hospital']);

            $hosAddress = $modelH->getHospitalName() . ', ' . $modelH->getAddress();
			
			$modelC = Mage::getModel('scan/scandoctors')->load($data['doctor']);
			$doctor = $modelC->getDoctorName().', '.$modelC->getQualification();
			

            $currentTimestamp = Mage::getModel('core/date')->timestamp(time()); //Magento's timestamp function makes a usage of timezone and converts it to timestamp
            $date = date('Y-m-d h:i:s', $currentTimestamp); //The value may differ than above because of the timezone settings.

            $settings = Mage::helper('smsnotifications/data')->getSettings();
            $text = Mage::getStoreConfig('smsnotifications/scan_content/customersurgey_sms');
            $text = str_replace('{{appointment}}', $data['appointment_date'], $text);
            $text = str_replace('{{doctor}}', $doctor, $text);
            $text = str_replace('{{address}}', $hosAddress, $text);
			$text = str_replace('{{scan}}', $data['scan_type'], $text);

            array_push($settings['order_noficication_recipients'], $data['phone']);

            $result = Mage::helper('smsnotifications/data')->sendSms($text, $settings['order_noficication_recipients']);

            //return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
	
	public function sendConfirmMail($data) {
        try {

            $modelH = Mage::getModel('scan/scanhospital')->load($data['hospital']);
			
			$modelC = Mage::getModel('scan/scandoctors')->load($data['doctor']);
			$doctor = $modelC->getDoctorName().', '.$modelC->getQualification();

            $templateId =7;
            $sender = Array('name' => Mage::getStoreConfig('trans_email/ident_support/name'),
            'email' => Mage::getStoreConfig('trans_email/ident_support/email'));
            //recepient
            $email = $data['email'];
            $emaiName = $data['name'];

            $emailTemplateVariables = array();
			$emailTemplateVariables['scan']=$data['scan_type'];
            $emailTemplateVariables['bookid']=$data['bmsbooking_code'];
            $emailTemplateVariables['custname']=$data['name'];
            $emailTemplateVariables['appointment']=$data['appointment_date'];
            $emailTemplateVariables['hospital']=$modelH->getHospitalName();
            $emailTemplateVariables['address']= $modelH->getAddress();
            $emailTemplateVariables['doctor']= $doctor;

            $storeId = Mage::app()->getStore()->getId();
            $translate = Mage::getSingleton('core/translate');
            Mage::getModel('core/email_template')
                    ->sendTransactional($templateId, $sender, $email, $emailName, $emailTemplateVariables, $storeId);
            $translate->setTranslateInline(true);

        } catch (Exception $er) {
            return $er->getMessage();
        }
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