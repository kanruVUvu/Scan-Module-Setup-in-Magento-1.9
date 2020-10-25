<?php

class Bms_Scan_Block_Adminhtml_Scanprices_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('ScanpricesGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('scan/scanprices')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('scan')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));


      // $this->addColumn('created_time', array(
          // 'header'    => Mage::helper('scan')->__('Date & Time'),
          // 'align'     =>'right',
          // 'width'     => '50px',
          // 'index'     => 'created_time',
      // ));

      // $this->addColumn('attend_time', array(
      //     'header'    => Mage::helper('scan')->__('Res.Time'),
      //     'align'     =>'left',
      //     'index'     => 'attend_time',
      // ));

      $this->addColumn('scan', array(
          'header'    => Mage::helper('scan')->__('Scan'),
          'align'     =>'left',
          'index'     => 'scan',
		  'type'      => 'options',
          'options'   => $this->getScanList(),
      ));
	  
	  $this->addColumn('scancategory', array(
          'header'    => Mage::helper('scan')->__('US_Subcat'),
          'align'     =>'left',
          'index'     => 'scancategory',
      ));
	  
	   $this->addColumn('scanxray', array(
          'header'    => Mage::helper('scan')->__('XRAY_Subcat'),
          'align'     =>'left',
          'index'     => 'scanxray',
      ));

     /* $this->addColumn('scan_type', array(
          'header'    => Mage::helper('scan')->__('Scan Type'),
          'align'     =>'left',
          'index'     => 'scan_type',
      )); */

      $this->addColumn('hospital', array(
          'header'    => Mage::helper('scan')->__('Hospital'),
          'align'     =>'left',
          'index'     => 'hospital',
		  'type'      => 'options',
          'options'   => $this->getHospitalLocation(),
		  
      ));
	  
	  $this->addColumn('hospital_price', array(
          'header'    => Mage::helper('scan')->__('Direct Price'),
          'align'     =>'left',
          'index'     => 'hospital_price',
      ));
	  
	  $this->addColumn('bms_price', array(
          'header'    => Mage::helper('scan')->__('BMS Price'),
          'align'     =>'left',
          'index'     => 'bms_price',
      ));
	  
	  $this->addColumn('consultation_charge', array(
          'header'    => Mage::helper('scan')->__('Consul.Price'),
          'align'     =>'left',
          'index'     => 'consultation_charge',
      ));
	  
	  $this->addColumn('additional_charge', array(
          'header'    => Mage::helper('scan')->__('Addtional Charge'),
          'align'     =>'left',
          'index'     => 'additional_charge',
      ));
	  
	  $this->addColumn('remarks', array(
          'header'    => Mage::helper('scan')->__('Remarks'),
          'align'     =>'left',
          'index'     => 'remarks',
      ));

      // $this->addColumn('status', array(
          // 'header'    => Mage::helper('scan')->__('Status'),
          // 'align'     => 'left',
          // 'width'     => '80px',
          // 'index'     => 'status',
          // 'type'      => 'options',
          // 'options'   => array(
              // 1 => 'Enable',
              // 2 => 'Disable',
          // ),
      // ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('scan')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('scan')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('scan')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('scan')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    // protected function _prepareMassaction()
    // {
    //     $this->setMassactionIdField('scan_id');
    //     $this->getMassactionBlock()->setFormFieldName('scan');

    //     $this->getMassactionBlock()->addItem('delete', array(
    //          'label'    => Mage::helper('scan')->__('Delete'),
    //          'url'      => $this->getUrl('*/*/massDelete'),
    //          'confirm'  => Mage::helper('scan')->__('Are you sure?')
    //     ));

    //     $statuses = Mage::getSingleton('scan/status')->getOptionArray();

    //     array_unshift($statuses, array('label'=>'', 'value'=>''));
    //     $this->getMassactionBlock()->addItem('status', array(
    //          'label'=> Mage::helper('scan')->__('Change status'),
    //          'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
    //          'additional' => array(
    //                 'visibility' => array(
    //                      'name' => 'status',
    //                      'type' => 'select',
    //                      'class' => 'required-entry',
    //                      'label' => Mage::helper('scan')->__('Status'),
    //                      'values' => $statuses
    //                  )
    //          )
    //     ));
    //     return $this;
    // }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
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
  }
  
  public function getHospitalLocation() {
       // $location = Mage::getModel('vendors/vendors')->load($v_id);
        $hospitals = Mage::getModel('scan/scanprices')->getCollection()->setOrder('hospital', 'ASC');
        foreach ($hospitals as $values) {
			$vendors = Mage::getModel('scan/scanhospital')->load($values['hospital']);
            $str[$vendors['id']] = $vendors['hospital_name'].' (' .$vendors['sub_location'].')';
        }
        return $str;
   }

}