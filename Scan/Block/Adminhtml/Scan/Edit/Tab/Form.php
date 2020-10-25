<?php

class Bms_Scan_Block_Adminhtml_Scan_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('scan_form', array('legend'=>Mage::helper('scan')->__('Item information')));
      
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
		  'values'    => Mage::helper('scan')->getHospitalsList(),
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
                  'value'     => 'Test1_USG',
                 'label'     => Mage::helper('scan')->__('Test1_USG'),
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

      $fieldset->addField('mrp', 'text', array(
          'label'     => Mage::helper('scan')->__('MRP'),
         // 'class'     => 'required-entry',
         // 'required'  => true,
          'name'      => 'mrp',
      ));

     $fieldset->addField('price', 'text', array(
          'label'     => Mage::helper('scan')->__('Price'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'price',
      ));
      
	 // $fieldset->addField('registered', 'button', array(
     //    'label'   => Mage::helper('core')->__('Add Item'),
     //     'value' => Mage::helper('core')->__('Add Item'),
     //       'name'  => 'registered',
     //      'class' => 'form-button',
	//	   'style' => 'width:100px',
           //'onclick' => "checkslot()",
     //  ));
	 
	 // Select field
       /* $fieldset->addField('style_content', 'button', array(
            'label' => $this->__('Adding New Subcategory'),
			'style' => 'width:100px',
            'onclick' => 'myFunction()',
            'value' => 'Add Item'
        ));
		
		
		 $fieldset->setAfterElementHtml('
                        <script>
                       document.getElementById("mrp").style.display = "none";
                       var cells = document.getElementsByClassName("times");
                        
                        function myFunction() {
                            var x = document.getElementById("mrp");

                            if (x.style.display === "none") {
                                x.style.display = "block";
                               document.getElementById("style_content").value="Remove the Item";
                                // document.getElementById("note_confirm").style.visibility = "visible";
                                for (var i = 0; i < cells.length; i++) { 
                                    cells[i].disabled = true;
                                }


                            } else {
                                x.style.display = "none";
                                x.value = "";
                                document.getElementById("style_content").value = "Add Item";
                               // document.getElementById("note_confirm").style.visibility = "hidden";
                                for (var i = 0; i < cells.length; i++) { 
                                    cells[i].disabled = false;
                                }
                            }
                      }
                        </script>
                    '); */

						 
						 
      $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('scan')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	   ));

      // $fieldset->addField('address', 'textarea', array(
          // 'label'     => Mage::helper('scan')->__('Address'),
          // 'class'     => 'required-entry',
          // 'required'  => true,
          // 'name'      => 'address',
		  // 'style'	  =>'height: 6em;',
      // ));
	  
	  // $fieldset->addField('map_url', 'textarea', array(
          // 'label'     => Mage::helper('scan')->__('Map Url'),
          // 'class'     => 'required-entry',
          // 'required'  => true,
          // 'name'      => 'map_url',
		  // 'style'	  =>'height: 6em;',
      // ));

      $fieldset->addField('usp', 'textarea', array(
          'label'     => Mage::helper('scan')->__('USP'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'usp',
      ));
	  
	  $fieldset->addField('speciality', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Speciality'),
         'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'speciality',
      ));


      
	  $fieldset->addField('price_list', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Price List'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_list',
      ));

      $fieldset->addField('description', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Description'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'description',
      ));
	  
	  $fieldset->addField('metatitle', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Meta Title'),
          'name'      => 'metatitle',
		  'style'	  =>'height: 4em;',
      ));
	  
	  $fieldset->addField('metakey', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Meta Keywords'),
          'name'      => 'metakey',
		  'style'	  =>'height: 8em;',
      ));
	  
	  $fieldset->addField('metadescription', 'textarea', array(
          'label'     => Mage::helper('scan')->__('Meta Description'),
          'name'      => 'metadescription',
		  'style'	  =>'height: 10em;',
      ));
	  

       $fieldset->addField('sort_no', 'text', array(
          'label'     => Mage::helper('scan')->__('Sort Order'),
         // 'class'     => 'required-entry',
         // 'required'  => true,
          'name'      => 'sort_no',
      ));
	  
	  $fieldset->addField('custom_url', 'text', array(
          'label'     => Mage::helper('scan')->__('Url Key'),
         // 'class'     => 'required-entry',
         // 'required'  => true,
          'name'      => 'custom_url',
      ));

		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('scan')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('scan')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('scan')->__('Disabled'),
              ),
          ),
      ));
	  
	 // $this->setChild('form_after',
     //       $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
	  //		->addFieldMap('scansub_type', 'scansub_type')
      //     ->addFieldDependence('scansub_type', 'scan_type', 'UltraSound')
		//	->addFieldDependence('scansub_type,'scan_type', 'X-ray')
		//	);
			
      if ( Mage::getSingleton('adminhtml/session')->getScanData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getScanData());
          Mage::getSingleton('adminhtml/session')->setScanData(null);
      } elseif ( Mage::registry('scan_data') ) {
          $form->setValues(Mage::registry('scan_data')->getData());
      }
     // return parent::_prepareForm();
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
	//$array2=array('ACL'=>'ACL');
    //$array3=array('UltraSound'=>'UltraSound','2d-Echo'=>'2d-Echo','Endoscopy'=>'Endoscopy','Colonoscopy'=>'Colonoscopy','Mammography'=>'Mammography','X-ray'=>'X-ray','TMT'=>'TMT','PFT'=>'PFT','ECG'=>'ECG','BMD/DEXA'=>'BMD/DEXA');
	//$abc=array_merge($cat,$array2,$array3);
	return $cat;
    //return $cat;
  } 
}