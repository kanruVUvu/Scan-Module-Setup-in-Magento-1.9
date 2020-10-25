<?php

class Bms_Scan_Block_Adminhtml_Scancompleted_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('scancompletedGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('scan/scancrm')->getCollection()->addFieldToFilter('status',3);
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
     $this->addColumn('id', array(
          'header'    => Mage::helper('scan')->__('ID'),
          'align'     =>'left',
          'width'     => '50px',
          'index'     => 'id',
      ));


      $this->addColumn('created_time', array(
          'header'    => Mage::helper('scan')->__('Date & Time'),
          'align'     =>'left',
          'width'     => '50px',
          'index'     => 'created_time',
		  'type' => 'datetime', 
		  'renderer'=>'Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Bookdate',
		  'filter_condition_callback' => array($this, 'dateFilter'),
      ));
	  
	  $this->addColumn('update_time', array(
          'header'    => Mage::helper('scan')->__('Last Update'),
          'align'     =>'left',
          'width'     => '50px',
          'index'     => 'update_time',
      ));
	  
	  // $this->addColumn('attend_time', array(
          // 'header'    => Mage::helper('scan')->__('Res.Time'),
          // 'align'     =>'left',
          // 'width'     => '40px',
          // 'index'     => 'attend_time',
      // ));
	  
	  $this->addColumn('location', array(
          'header'    => Mage::helper('scan')->__('City'),
          'align'     =>'left',
          'index'     => 'location',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('scan')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
	  
	  $this->addColumn('phone', array(
          'header'    => Mage::helper('scan')->__('Mobile'),
          'align'     =>'left',
          'index'     => 'phone',
      ));
	  
      // $this->addColumn('email', array(
          // 'header'    => Mage::helper('scan')->__('Email'),
          // 'align'     =>'left',
          // 'index'     => 'email',
      // ));
	  
	  // $this->addColumn('age', array(
          // 'header'    => Mage::helper('scan')->__('Age'),
          // 'align'     =>'left',
          // 'index'     => 'age',
      // ));

      $this->addColumn('scan_type', array(
          'header'    => Mage::helper('scan')->__('Scan Name'),
          'align'     =>'left',
          'index'     => 'scan_type',
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
	  
	   // $this->addColumn('appointment_date', array(
          // 'header'    => Mage::helper('scan')->__('App.Date'),
          // 'align'     =>'left',
          // 'index'     => 'appointment_date',
      // ));

      $this->addColumn('hospital', array(
          'header'    => Mage::helper('scan')->__('Hospital'),
          'align'     =>'left',
          'index'     => 'hospital',
		  'width'	  => '150px',
		  'type'      => 'options',
          'options'   => $this->getHospitalLocation(),
		 // 'renderer'  => 'Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Hospitals',
      ));
	  
	  $this->addColumn('scan_date', array(
          'header'    => Mage::helper('scan')->__('Scan Date'),
          'align'     =>'left',
          'index'     => 'scan_date',
      ));
	  
	  $this->addColumn('price', array(
          'header'    => Mage::helper('scan')->__('Price'),
          'align'     =>'left',
          'index'     => 'price',
		  'renderer' => 'Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Priceinline',
      ));
	  
	  $this->addColumn('leadowner', array(
          'header'    => Mage::helper('scan')->__('L.Owner'),
          'align'     =>'left',
          'index'     => 'leadowner',
      ));
	  
	  $this->addColumn('source_from', array(
          'header'    => Mage::helper('scan')->__('Source'),
          'align'     =>'left',
          'index'     => 'source_from',
      ));
	  
	  $this->addColumn('feedback', array(
          'header'    => Mage::helper('scan')->__('Feedback'),
          'align'     =>'left',
          'index'     => 'feedback',
      ));
	  
	  $this->addColumn('sendemail', array(
          'header'    => Mage::helper('scan')->__('Send Email'),
          'align'     =>'left',
          'index'     => 'sendemail',
		  'filter'    => false,
          'sortable'  => false,
		  'renderer' => 'Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Sendemail',
		  'width' => '70px',
      ));
	  
	  // $this->addColumn('action',
            // array(
                // 'header'    =>  Mage::helper('adminhtml')->__('Send Email'),
                // 'width'     => '75',
                // 'type'      => 'action',
                // 'getter'    => 'getId',
                // 'actions'   => array(
                    // array(
                        // 'caption'   => Mage::helper('adminhtml')->__('Send Email'),
                        // 'url'       => array('base'=> '*/*/sendinvoicemail'),
                        // 'field'     => 'id',
                        // 'title'     => 'Click to send invoice Email',
                        //'style'     => 'background-color: green;color: white;font-weight:bold;text-align: center;text-decoration: none;display: inline-block;padding:2px;'
                    // )
                // ),
                // 'filter'    => false,
                // 'sortable'  => false,
                // 'index'     => 'stores',
                // 'is_system' => true,
        // ));
	  
		
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
     // return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }
  
  protected function dateFilter($collection, $column)
	{
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
		
		$from=date("Y-m-d", strtotime($value['orig_from'])).' 00:00:00';
		$to=date("Y-m-d", strtotime($value['orig_to'])).' 23:59:59';
		
        $this->getCollection()->getSelect()->where(
            "created_time BETWEEN '$from' AND '$to'");

        return $this;
   }
   
    public function getHospitalLocation() {
       // $location = Mage::getModel('vendors/vendors')->load($v_id);
        $hospitals = Mage::getModel('scan/scancrm')->getCollection()->addFieldToFilter('status',3)->setOrder('hospital', 'ASC');
        foreach ($hospitals as $values) {
			$vendors = Mage::getModel('scan/scanhospital')->load($values['hospital']);
            $str[$vendors['id']] = $vendors['hospital_name'].' (' .$vendors['sub_location'].')';
        }
        return $str;
   }

}