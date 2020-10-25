<?php
class Bms_Scan_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
			
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function detailAction(){
		
    	$this->loadLayout();
		$catid=$this->getRequest()->getParam('catid');
		$hid=$this->getRequest()->getParam('hid');
		//$_category=Mage::getModel('catalog/category')->load($catid); 
		$hosp=Mage::getModel('scan/scan')->load($hid);
		
		//echo $_category->getName();
		$category = Mage::getResourceModel('catalog/category_collection')
        ->addFieldToFilter('name', $hosp->getScanType())->addAttributeToSelect('url_key')
        ->getFirstItem();
		
		//print_r($category->getData());
//echo $category->getId();
//echo $category->getUrlKey();
//die;
    	$breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
		$breadcrumbs->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 
                                     'title'=>Mage::helper('cms')->__('Home'), 
                                     'link'=>Mage::getBaseUrl()));
		$breadcrumbs->addCrumb('scan', array('label'=>Mage::helper('cms')->__('Scan'), 
                                     'title'=>Mage::helper('cms')->__('Scan'),
									 'link'=>Mage::getBaseUrl().'scan'));
		$breadcrumbs->addCrumb('details', array('label'=>$hosp->getScanType(), 
                                     'title'=>$hosp->getScanType(),
									 'link'=>Mage::getBaseUrl().$category->getUrlKey()));
		$breadcrumbs->addCrumb('hospital', array('label'=>$hosp->getHospital(), 
                                     'title'=>$hosp->getHospital()));
		$headBlock = $this->getLayout()->getBlock('head');
		$headBlock->setTitle($hosp->getMetatitle());
		$headBlock->setDescription($hosp->getMetadescription());
		$headBlock->setKeywords($hosp->getMetakey());
		$this->renderLayout();
    }
    public function bookscanAction(){
    	try{
	    	$data=$this->getRequest()->getPost();
			if($data['bmscheckbot']!="" || $data['bmsvaluebot']!='sanBMS'){
				Mage::getSingleton('core/session')->addError('Robot Entry');
			}
			else{
				$g_response = $this->getRequest()->getParam('g-recaptcha-response');
				if (isset($g_response) && !empty($g_response)){
					if (Mage::helper('recaptcha')->Validate_captcha($g_response)){
						if($data['email']!="" && $data['phone']!="" && $data['name']!=""){
							//echo "hi surgery";
							$currentTimestamp = Mage::getModel('core/date')->timestamp(time()); //Magento's timestamp function makes a usage of timezone and converts it to timestamp
							$date = date('Y-m-d H:i:s', $currentTimestamp);
							$data['created_time']=$date;
							$data['source_from']='Website';
							$model = Mage::getModel('scan/scancrm');
							$model->setdata($data);
							if($model->save()){
								$bms_code = 'SBMS' . str_pad($model->getId(), 5, '0', STR_PAD_LEFT);
								$model->setBmsbookingCode($bms_code);
								$model->save();
								
								$this->sendSMS($bms_code, $data);
								$this->sendMail($bms_code, $data);
							}
							$this->_redirect('scan-thank-you');
							Mage::getSingleton('core/session')->addSuccess('Data has been submitted');
						}
						else{
							$this->_redirectReferer();
							Mage::getSingleton('core/session')->addError('Unable to find item to save');
						}
					}
					else{
						$this->_redirectReferer();
						Mage::getSingleton('core/session')->addError('Please click on the reCAPTCHA box.');
					}
				}
				else{
					$this->_redirectReferer();
					Mage::getSingleton('core/session')->addError('Please click on the reCAPTCHA box.');
				}
			}
     	}
     	catch (Exception $e) {
            $this->_redirectReferer();
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }
    }
	
	public function sendSMS($bms_order_code, $data) {
        try {
            $currentTimestamp = Mage::getModel('core/date')->timestamp(time()); //Magento's timestamp function makes a usage of timezone and converts it to timestamp
            $date = date('Y-m-d h:i:s', $currentTimestamp); //The value may differ than above because of the timezone settings.

            $settings = Mage::helper('smsnotifications/data')->getSettings();
            $text = Mage::getStoreConfig('smsnotifications/health_content/scan_booking_sms');
            $text = str_replace('{{name}}', $data['name'], $text);
            $text = str_replace('{{order}}', $bms_order_code, $text);

            array_push($settings['order_noficication_recipients'], $data['phone']);

            $result = Mage::helper('smsnotifications/data')->sendSms($text, $settings['order_noficication_recipients']);

            //return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
	
	Public function sendMail($bms_order_code, $data){
		try {
			
			$templateId =6;
            $sender = Array('name' => Mage::getStoreConfig('trans_email/ident_support/name'),
            'email' => Mage::getStoreConfig('trans_email/ident_support/email'));
            //recepient
            $email = $data['email'];
            $emaiName = $data['name'];

            $emailTemplateVariables = array();
            $emailTemplateVariables['bookid']=$bms_order_code;
            $emailTemplateVariables['custname']=$data['name'];

            $storeId = Mage::app()->getStore()->getId();
            $translate = Mage::getSingleton('core/translate');
            Mage::getModel('core/email_template')
                    ->sendTransactional($templateId, $sender, $email, $emailName, $emailTemplateVariables, $storeId);
            $translate->setTranslateInline(true);
			
		 } catch (Exception $er) {
            return $er->getMessage();
        }
		
	}
	
	

}