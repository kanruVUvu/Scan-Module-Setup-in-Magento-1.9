<?php

class Bms_Scan_Block_Adminhtml_Scan_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('scanGrid');
      $this->setDefaultSort('scan_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('scan/scan')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('scan_id', array(
          'header'    => Mage::helper('scan')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'scan_id',
      ));
	  $this->addColumn('city', array(
          'header'    => Mage::helper('scan')->__('City'),
          'align'     =>'left',
          'index'     => 'city',
      ));
	  
	  $this->addColumn('scan_type', array(
          'header'    => Mage::helper('scan')->__('Scan'),
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
	  
	  
	//  $this->addColumn('scansub_type',array(
	//  'header'  => Mage::helper('scan')->__('ScanSubcategory'),
	//  'align'   =>'left',
	//  'index'   =>'scansub_type',
	//  ));
	  
	  
	  
      $this->addColumn('hospital', array(
          'header'    => Mage::helper('scan')->__('Hospital'),
          'align'     =>'left',
          'index'     => 'hospital',
      ));
	  
	   $this->addColumn('sort_no', array(
          'header'    => Mage::helper('scan')->__('Order by'),
          'align'     =>'left',
          'index'     => 'sort_no',
      ));

      // $this->addColumn('address', array(
          // 'header'    => Mage::helper('scan')->__('Address'),
          // 'align'     =>'left',
          // 'index'     => 'address',
      // ));

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
              1 => 'Enabled',
              2 => 'Disabled',
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
		//$this->addExportType('*/*/exportXml', Mage::helper('scan')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('scan_id');
        $this->getMassactionBlock()->setFormFieldName('scan');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('scan')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('scan')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('scan/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('scan')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('scan')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}