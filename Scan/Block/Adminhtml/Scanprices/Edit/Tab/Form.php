<?php

class Bms_Scan_Block_Adminhtml_Scanprices_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('scanprices_form', array('legend'=>Mage::helper('scan')->__('Item information')));
     
	  
	  $fieldset->addField('city', 'select', array(
          'label'     => Mage::helper('scan')->__('City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'city',
          'values'    => $this->getCityList()
      ));
	 
      $fieldset->addField('hospital', 'select', array(
          'label'     => Mage::helper('scan')->__('Hospital'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'hospital',
		  'values'    => $this->getHospitalLocation(),
      ));
	  
	   $fieldset->addField('scan_type', 'select', array(
          'label'     => Mage::helper('scan')->__('Scan'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'scan_type',
		  //'value'     => $model->getFormCode(),
		  'values'    => $this->getScanList(),
		 // 'value'     => $model->getScanList()
		/* 'values'    => array(
               array(
                  'value'     => '',
                  'label'     => '-------- Select Scan ------',
              ),
              array(
                  'value'     => 'Ultrasound',
                  'label'     => 'Ultrasound',
              ),
              array(
                  'value'     => '2D Echo',
                  'label'     => '2D Echo',
              ),
              array(
                  'value'     => 'X-Ray',
                  'label'     => 'X-Ray',
              ),
            ), */
      ));
	  
      $fieldset->addField('scancategory', 'select', array(
          'label'     => Mage::helper('scan')->__('UltraSoundDropDown'),
	  	 //'required'  => true,
          'name'      => 'scancategory',
          'values'    => array(
		              array(
					    'value' => ' ',
						'label' => Mage::helper('scan')->__('----Select USG Subcategory----'),
						),
               array(
                  'value'     => 'sub1',
                 'label'     => Mage::helper('scan')->__('sub1'),
              ),
  
              array(
                  'value'     => 'sub2',
                 'label'     => Mage::helper('scan')->__('sub2'),
             ),
          ),
		   'note' => 'UltraSound Sub-Dropdown Menu',
       ));
	   
	   $fieldset->addField('scanxray', 'select', array(
         'label'     => Mage::helper('scan')->__('X-rayDropDown'),
	 	//'required'  => true,
        'name'      => 'scanxray',
      'values'    => array(
	             array(
					    'value' => ' ',
						'label' => Mage::helper('scan')->__('----Select XRAY Subcategory----'),
						),
           array(
         'value'     => 'sub3',
            'label'     => Mage::helper('scan')->__('sub3'),
            ),
             array(
             'value'     => 'sub4',
           'label'     => Mage::helper('scan')->__('sub4'),
          ),
           ),
		  'note' => 'X-Ray Sub-Dropdown Menu',
       ));  


      $fieldset->addField('hospital_price', 'text', array(
          'label'     => Mage::helper('scan')->__('Direct Price'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'hospital_price',
		  'note'      => '(Excluding Implant)',
      ));
	  
	  $fieldset->addField('bms_price', 'text', array(
          'label'     => Mage::helper('scan')->__('BMS Price'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'bms_price',
		  'note'      => '(Excluding Implant)',
      ));
	  
	  $fieldset->addField('consultation_charge', 'text', array(
          'label'     => Mage::helper('scan')->__('Consulation Charge'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'consultation_charge',
      ));

	  $fieldset->addField('additional_charge', 'text', array(
          'label'     => Mage::helper('scan')->__('Addtional Charge'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'additional_charge',
      ));
	  
	  $fieldset->addField('remarks', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Remarks'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'remarks',
      ));
	  
		
     
      if ( Mage::getSingleton('adminhtml/session')->getScanpricesData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getScanpricesData());
          Mage::getSingleton('adminhtml/session')->setScanpricesData(null);
      } elseif ( Mage::registry('scanprices_data') ) {
          $form->setValues(Mage::registry('scanprices_data')->getData());
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
  
  public function getScanList(){
    $children = Mage::getModel('catalog/category')->load(28);
	$subcats = $children->getChildren();
	foreach(explode(',',$subcats) as $subCatid)
	{
		 $_category = Mage::getModel('catalog/category')->load($subCatid);
		 $cat[$_category->getName()]=$_category->getName();
	}
    return $cat;
    //return $cat;
  }
  
  public function getHospitalLocation() {
       // $location = Mage::getModel('vendors/vendors')->load($v_id);
        $vendors = Mage::getModel('scan/scanhospital')->getCollection()->setOrder('hospital_name', 'ASC');
		$str[]="-----Select Hospital-----";
        foreach ($vendors as $values) {
            $str[$values['id']] = $values['hospital_name'].' (' .$values['sub_location'].')';
        }
        return $str;
   }
}