<?php

class Bms_Scan_Block_Adminhtml_Scanpostponed_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('scanpostponedGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('scan/scancrm')->getCollection()->addFieldToFilter('status',5);
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
      ));

      $this->addColumn('attend_time', array(
          'header'    => Mage::helper('scan')->__('Res.Time'),
          'align'     =>'left',
          'index'     => 'attend_time',
      ));
	  
	  $this->addColumn('postpone_date', array(
          'header'    => Mage::helper('scan')->__('Postponed On'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'postpone_date',
		  'renderer'  => 'Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Postponeddate',
      ));

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
      ));


      $this->addColumn('price', array(
          'header'    => Mage::helper('scan')->__('Price'),
          'align'     =>'left',
          'index'     => 'price',
      ));

      $this->addColumn('leadowner', array(
          'header'    => Mage::helper('scan')->__('Lead Owner'),
          'align'     =>'left',
          'index'     => 'leadowner',
      ));

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

      $this->addColumn('status', array(
          'header'    => Mage::helper('scan')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
			  2 => 'Confirmed',
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

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}