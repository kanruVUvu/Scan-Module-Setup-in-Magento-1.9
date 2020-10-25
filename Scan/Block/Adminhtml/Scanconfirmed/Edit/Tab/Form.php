<?php

class Bms_Scan_Block_Adminhtml_Scanconfirmed_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('scanconfirmed_form', array('legend'=>Mage::helper('scan')->__('Item information')));
     
      $fieldset->addField('bmsbooking_code', 'text', array(
          'label'     => Mage::helper('scan')->__('Order Code'),
          'class'     => 'required-entry',
          'readonly'  => true,
          'name'      => 'bmsbooking_code',
      ));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('scan')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));

      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('scan')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'email',
      ));

     $fieldset->addField('phone', 'text', array(
          'label'     => Mage::helper('scan')->__('Phone'),
          'class'     => 'required-entry',
          'required'  => true,
		  'class'     => 'unique-entry',
		  'unique'    => true,
          'name'      => 'phone',
		  
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

      $fieldset->addField('hospital', 'text', array(
          'label'     => Mage::helper('scan')->__('Hospital'),
          'required'  => false,
          'name'      => 'hospital',
	   ));

       $fieldset->addField('price', 'text', array(
          'label'     => Mage::helper('scan')->__('price'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price',
      ));

      $fieldset->addField('feedback', 'text', array(
          'label'     => Mage::helper('scan')->__('Feedback'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'feedback',
      ));


      $fieldset->addField('postpone_date', 'date', array(
                'label'     => Mage::helper('scan')->__('Postpond Date'),
                'name' => 'postpone_date',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format' => 'y-M-d',
                //'required' => true,
                'class' => 'validate-date validate-date-range date-range-custom_theme-from'
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
                  'value'     => 3,
                  'label'     => Mage::helper('scan')->__('Completed'),
              ),
              array(
                  'value'     => 4,
                  'label'     => Mage::helper('scan')->__('Rejected'),
              ),
              array(
                  'value'     => 5,
                  'label'     => Mage::helper('scan')->__('Postponed'),
              ),
          ),
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getScanData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getScanvData());
          Mage::getSingleton('adminhtml/session')->setScancrmData(null);
      } elseif ( Mage::registry('scancrm_data') ) {
          $form->setValues(Mage::registry('scancrm_data')->getData());
      }
      return parent::_prepareForm();
  }
}