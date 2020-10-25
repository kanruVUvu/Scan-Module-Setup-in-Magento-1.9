<?php

class Bms_Scan_Adminhtml_ScancompletedController extends Mage_Adminhtml_Controller_action
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
	
	public function invoicepriceAction() {
		$params = $this->getRequest()->getPost();
        $data = Mage::getModel('scan/scancrm')->load($params['id']);
		if($data){
            try{
				$currentTimestamp = Mage::getModel('core/date')->timestamp(time());
                $data->setPrice($params['price']);
				$data->setUpdateTime(date('Y-m-d h:i:s', $currentTimestamp));
                $data->save();
				Mage::getSingleton('adminhtml/session')->addSuccess('Price Updated successfully');
                $response='Updated Successfully!';
            } catch (Exception $e) {
                $response="Update Fail";
            }
            echo $response;
        }
	}
	
	public function updatefeedbackAction() {
		$params = $this->getRequest()->getPost();
        $data = Mage::getModel('scan/scancrm')->load($params['id']);
		
		$aruser = Mage::getSingleton('admin/session');
        $aruserId = $aruser->getUser()->getUsername();
		
		if($data){
            try{
				$currentTimestamp = Mage::getModel('core/date')->timestamp(time());
                $data->setFeedback($params['feedback']);
				$data->setUpdateTime(date('Y-m-d h:i:s', $currentTimestamp));
                $data->save();
				
				$status="Completed";
				
				$history = Mage::getSingleton('core/resource')->getConnection('core_write');
        		$history->insert(
                	"bs_historymap", array("cid" => $params['id'], "coupon_code" => $data->getBmsbookingCode(), "name" => $data->getName(), "updated_by" => $aruserId, "time" =>date('Y-m-d H:i:s', $currentTimestamp), "status" =>$status ,"follow_comments"=> $params['feedback'],"enq_type"=>"scan")
        		);
				
				//Mage::getSingleton('adminhtml/session')->addSuccess('feedback Updated successfully');
               $response='Updated Successfully!';
            } catch (Exception $e) {
                $response="Update Fail";
            }
           echo $response;
        }
	}
	
	Public function sendinvoicemailAction(){
		try{
			$id     = $this->getRequest()->getParam('id');
			if($id){
				$scan=Mage::getModel('scan/scancrm')->load($id);
				$modelH = Mage::getModel('scan/scanhospital')->load($scan->getHospital());
				
				$templateId =8;
				$sender = Array('name' => Mage::getStoreConfig('trans_email/ident_support/name'),
				'email' => Mage::getStoreConfig('trans_email/ident_support/email'));
				//recepient
				$email = $modelH->getContactEmail();
				$emaiName = $modelH->getContactPerson();

				$emailTemplateVariables = array();
				$emailTemplateVariables['scan']=$scan->getScanType();
				$emailTemplateVariables['custname']=$scan->getName();
				$emailTemplateVariables['poc']=$modelH->getContactPerson();
			  //  $emailTemplateVariables['appointment']=$data['appointment_date'];
				$emailTemplateVariables['hospital']=$modelH->getHospitalName();
				//$emailTemplateVariables['address']= $modelH->getAddress();

				$storeId = Mage::app()->getStore()->getId();
				$translate = Mage::getSingleton('core/translate');
				Mage::getModel('core/email_template')
						->sendTransactional($templateId, $sender, $email, $emailName, $emailTemplateVariables, $storeId);
				$translate->setTranslateInline(true);
				Mage::getSingleton('adminhtml/session')->addSuccess('Mail send successfully');
				
			}
			$this->_redirectReferer();
			
		}catch(Exception $e){
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirectReferer();
		}
	}
 
	protected function _isAllowed()  
    {  
        return true;  
    } 

    public function exportCsvAction()
    {
        $fileName   = 'scancompleted.csv';
        $content    = $this->getLayout()->createBlock('scan/adminhtml_scancompleted_grid')
            ->getCsv();

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