<?php

class Bms_Scan_Block_Adminhtml_Scanpostponed_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('scanpostponed_form', array('legend'=>Mage::helper('scan')->__('Item information')));
		
	  $crmid=$this->getRequest()->getParam('id');
	  
	  $fieldset->addField('created_time', 'text', array(
          'label'     => Mage::helper('scan')->__('Date & Time'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'created_time',
		  'readonly' =>true,
      ));
		
      $fieldset->addField('bmsbooking_code', 'text', array(
          'label'     => Mage::helper('scan')->__('Order Code'),
          'class'     => 'required-entry',
          'readonly'  => true,
          'name'      => 'bmsbooking_code',
      ));
	  
	  $fieldset->addField('location', 'text', array(
          'label'     => Mage::helper('scan')->__('City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'location',
      ));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('scan')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
	  
	   $fieldset->addField('phone', 'text', array(
          'label'     => Mage::helper('scan')->__('Phone'),
          'class'     => 'required-entry',
          'required'  => true,
		  'class'     => 'unique-entry',
		  'unique'    => true,
          'name'      => 'phone',
		  'readonly'  => true ,
      ));
	  
	  $fieldset->addField('alternate_phone', 'text', array(
          'label'     => Mage::helper('scan')->__('Alternate Phone No'),
         // 'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'alternate_phone',
		  //'readonly'  => true,
      ));
	  
	  $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('scan')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'email',
      ));
	  
	  $fieldset->addField('age', 'text', array(
          'label'     => Mage::helper('scan')->__('Age'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'age',
      ));
		
		$fieldset->addField('scan_type', 'text', array(
          'label'     => Mage::helper('scan')->__('Category'),
          'required'  => false,
          'name'      => 'scan_type',
     ));
	  
	   $fieldset->addField('scancategory', 'text', array(
          'label'     => Mage::helper('scan')->__('US_subcategory'),
          'required'  => false,
          'name'      => 'scancategory',
		  'note' => 'UltraSound Sub-Category',
     ));
	  
	  $fieldset->addField('scanxray', 'text', array(
          'label'     => Mage::helper('scan')->__('X-ray_subcategory'),
          'required'  => false,
          'name'      => 'scanxray',
		  'note' => 'X-Ray Sub-Category',
     ));
	   
	   $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('scan')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('scan')->__('Confirmed'),
              ),
              array(
                  'value'     => 4,
                  'label'     => Mage::helper('scan')->__('Rejected'),
              ),
              array(
                  'value'     => 5,
                  'label'     => Mage::helper('scan')->__('Postponed'),
              ),
			  array(
                  'value'     => 6,
                  'label'     => Mage::helper('scan')->__('RNR'),
              ),
          ),
      ));
	  
	  
      $fieldset->addField('hospital', 'select', array(
          'label'     => Mage::helper('scan')->__('Hospital'),
          'required'  => false,
          'name'      => 'hospital',
		  'values'	  => $this->getHospitalLocation(),
	   ));
	   
	 //  $fieldset->addField('doctor', 'select', array(
     //     'label'     => Mage::helper('scan')->__('Doctor'),
     //     'required'  => false,
     //     'name'      => 'doctor',
	//	  'values'	  => $this->getScanDoctors($crmid),
	 //  ));
	   
	  $dateTimeFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
	  $fieldset->addField('appointment_date', 'datetime', array(
          'label'     => Mage::helper('scan')->__('Appointment Date'),
          'required'  => true,
          'name'      => 'appointment_date',
		  'image' 	  => $this->getSkinUrl('images/grid-cal.gif'),
		 // 'input_format' => $dateTimeFormatIso,
		  'format'       => $dateTimeFormatIso,
		  'time' => true,
	   ));


       $fieldset->addField('price', 'text', array(
          'label'     => Mage::helper('scan')->__('price'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price',
      ));

      $fieldset->addField('feedback', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Feedback'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'feedback',
		   'style'	  => 'height:4em;',
      ));


      $fieldset->addField('postpone_date', 'datetime', array(
			'label'=> Mage::helper('scan')->__('Postponed Date&Time'),
			'name' => 'postpone_date',
			'image' => $this->getSkinUrl('images/grid-cal.gif'),
			'format' => $dateTimeFormatIso,
			'required' => true,
			'time' => true,
			'readonly'=>true,
      )); 
	  
		$fieldset->addField('confirm_email', 'checkbox', array(
          'label'     => Mage::helper('scan')->__('Send Confirmed Email'),        
          'name'      => 'confirm_email',        
          'onclick' => 'this.value = this.checked ? 1 : 0;',            
          'tabindex' => 1  
        ));
		
		$fieldset->addField('confirm_sms', 'checkbox', array(
          'label'     => Mage::helper('scan')->__('Send Confirmed SMS'),        
          'name'      => 'confirm_sms',        
          'onclick' => 'this.value = this.checked ? 1 : 0;',            
          'tabindex' => 1  
        ));
		
		$fieldset->addField('sendrnrsms', 'checkbox', array(
          'label'     => Mage::helper('scan')->__('Send RNR SMS'),        
          'name'      => 'sendrnrsms',        
          'onclick' => 'this.value = this.checked ? 1 : 0;',            
          'tabindex' => 1  
        ));


	 $this->setChild('form_after',
            $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap('status', 'status')
			->addFieldMap('appointment_date', 'appointment_date')
            ->addFieldMap('postpone_date', 'postpone_date')
			->addFieldDependence('appointment_date', 'status', 2)
			->addFieldDependence('postpone_date', 'status', 5)
            );
    
     
		if ( Mage::getSingleton('adminhtml/session')->getScanData() )
		{
          $form->setValues(Mage::getSingleton('adminhtml/session')->getScanData());
          Mage::getSingleton('adminhtml/session')->setScanpostponedData(null);
		} elseif ( Mage::registry('scanpostponed_data') ) {
          $form->setValues(Mage::registry('scanpostponed_data')->getData());
		}
      return parent::_prepareForm();
  }
  
  public function getHospitalLocation() {
       // $location = Mage::getModel('vendors/vendors')->load($v_id);
        $vendors = Mage::getModel('scan/scanhospital')->getCollection()->addFieldToFilter('status', 1)->setOrder('hospital_name', 'ASC');
		$str[]="-----Select Hospital-----";
        foreach ($vendors as $values) {
            $str[$values['id']] = $values['hospital_name'].' (' .$values['sub_location'].')';
        }
        return $str;
   }
   
   // public function getScanDoctors($id) {
   //     $crm = Mage::getModel('scan/scancrm')->load($id);
  //      $vendors = Mage::getModel('scan/scandoctors')->getCollection()->addFieldToFilter('scan_type', $crm->getScanType())->setOrder('hospital', 'ASC');
	//	$str[]="-----Select Doctor-----";
  //      foreach ($vendors as $values) {
  //          $str[$values['id']] = $values['doctor_name'].' (' .$values['hospital'].')';
  //      }
  //      return $str;
  // }
	
 
}