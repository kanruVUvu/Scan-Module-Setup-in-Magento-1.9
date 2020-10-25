<?php

class Bms_Scan_Block_Adminhtml_Scanhospital_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('scanhospital_form', array('legend'=>Mage::helper('scan')->__('Item information')));
     
	  
	  $fieldset->addField('city', 'select', array(
          'label'     => Mage::helper('scan')->__('City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'city',
          'values'    => $this->getCityList()
      ));
	 
      $fieldset->addField('hospital_name', 'select', array(
          'label'     => Mage::helper('scan')->__('Hospital'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'hospital_name',
		  'values'	  => Mage::helper('scan')->getHospitalsList(),
      ));

      $fieldset->addField('sub_location', 'text', array(
          'label'     => Mage::helper('scan')->__('Sub Location'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'sub_location',
      ));

     $fieldset->addField('address', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Address'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'address',
      ));
	  
	  $fieldset->addField('contact_person', 'text', array(
          'label'     => Mage::helper('scan')->__('Contact Person 1'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_person',
      ));
	  
	  $fieldset->addField('contact_email', 'text', array(
          'label'     => Mage::helper('scan')->__('Contact Email 1'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_email',
      ));
	  
	  $fieldset->addField('contact_no', 'text', array(
          'label'     => Mage::helper('scan')->__('Contact Number 1'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_no',
      ));
	  
	   $fieldset->addField('contact_name', 'text', array(
          'label'     => Mage::helper('scan')->__('Contact Person 2'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_name',
      ));
	  
	  $fieldset->addField('contact_emailid', 'text', array(
          'label'     => Mage::helper('scan')->__('Contact Email 2'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_emailid',
      ));
	  
	  
	  $fieldset->addField('contact_phone', 'text', array(
          'label'     => Mage::helper('scan')->__('Contact Number 2'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contact_phone',
      ));
	  
	  $fieldset->addField('emi_option', 'select', array(
          'label'     => Mage::helper('scan')->__('Is EMI available ?'),
          'name'      => 'emi_option',
		  'class'     => 'required-entry',
          'required'  => true,
          'values'    => array(
			array(
                  'value'     => '',
                  'label'     => Mage::helper('scan')->__('--Select--'),
              ),
              array(
                  'value'     => 'Yes',
                  'label'     => Mage::helper('scan')->__('Yes'),
              ),

              array(
                  'value'     => 'No',
                  'label'     => Mage::helper('scan')->__('No'),
              ),
          ),
      ));
	  
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('scan')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('scan')->__('Enable'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('scan')->__('Disable'),
              ),
          ),
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getScanhospitalData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getScanhospitalData());
          Mage::getSingleton('adminhtml/session')->setScanhospitalData(null);
      } elseif ( Mage::registry('scanhospital_data') ) {
          $form->setValues(Mage::registry('scanhospital_data')->getData());
      }
      return parent::_prepareForm();
  }
  public function getCityList(){
    foreach (Mage::app()->getWebsites() as $website) {
      foreach ($website->getGroups() as $group) {
        $stores = $group->getStores();
        foreach ($stores as $store) {
           // echo $store->getCode() ." ".$store->getName()."<br/>";
            $str[$store->getName()] = $store->getName();
        }
      }
    }
    return $str;
  }
}