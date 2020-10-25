<?php

class Bms_Scan_Block_Adminhtml_Scanconfirmed_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('scancrmGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('scan/scancrm')->getCollection()->addFieldToFilter('status',2);
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


      $this->addColumn('created_time', array(
          'header'    => Mage::helper('scan')->__('Date & Time'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'created_time',
		  'type' => 'datetime', 
		  'renderer'=>'Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Bookdate',
		  'filter_condition_callback' => array($this, 'dateFilter'),
      ));

      // $this->addColumn('attend_time', array(
      //     'header'    => Mage::helper('scan')->__('Res.Time'),
      //     'align'     =>'left',
      //     'index'     => 'attend_time',
      // ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('scan')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));

      $this->addColumn('email', array(
          'header'    => Mage::helper('scan')->__('Email'),
          'align'     =>'left',
          'index'     => 'email',
      ));

      $this->addColumn('phone', array(
          'header'    => Mage::helper('scan')->__('Phone'),
          'align'     =>'left',
          'index'     => 'phone',
      ));

      $this->addColumn('scan_type', array(
          'header'    => Mage::helper('scan')->__('Category'),
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

      $this->addColumn('hospital', array(
          'header'    => Mage::helper('scan')->__('Hospital'),
          'align'     =>'left',
          'index'     => 'hospital',
		  'type'      => 'options',
          'options'   => $this->getHospitalLocation(),
      ));


      $this->addColumn('price', array(
          'header'    => Mage::helper('scan')->__('Price'),
          'align'     =>'left',
          'index'     => 'price',
      ));

      // $this->addColumn('leadowner', array(
      //     'header'    => Mage::helper('scan')->__('Lead Owner'),
      //     'align'     =>'left',
      //     'index'     => 'leadowner',
      // ));

      $this->addColumn('feedback', array(
          'header'    => Mage::helper('scan')->__('Feedback'),
          'align'     =>'left',
          'index'     => 'feedback',
      ));

      $this->addColumn('source_from', array(
          'header'    => Mage::helper('scan')->__('Source'),
          'align'     =>'left',
          'index'     => 'source_from',
      ));


	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('scan')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('scan')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
			  3 => 'Completed',
			  4 => 'Rejected',
			  5 => 'Postponed',
          ),
      ));
	  
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
		$this->addExportType('*/*/exportXml', Mage::helper('scan')->__('XML'));
	  
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
        $hospitals = Mage::getModel('scan/scancrm')->getCollection()->addFieldToFilter('status',2)->setOrder('hospital', 'ASC');
        foreach ($hospitals as $values) {
			$vendors = Mage::getModel('scan/scanhospital')->load($values['hospital']);
            $str[$vendors['id']] = $vendors['hospital_name'].' (' .$vendors['sub_location'].')';
        }
        return $str;
   }

}