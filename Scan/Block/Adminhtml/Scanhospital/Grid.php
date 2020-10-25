<?php

class Bms_Scan_Block_Adminhtml_Scanhospital_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('ScanhospitalGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('scan/scanhospital')->getCollection();
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

      // $this->addColumn('attend_time', array(
      //     'header'    => Mage::helper('scan')->__('Res.Time'),
      //     'align'     =>'left',
      //     'index'     => 'attend_time',
      // ));

      $this->addColumn('hospital_name', array(
          'header'    => Mage::helper('scan')->__('Hospital'),
          'align'     =>'left',
          'index'     => 'hospital_name',
      ));

      $this->addColumn('sub_location', array(
          'header'    => Mage::helper('scan')->__('Location'),
          'align'     =>'left',
          'index'     => 'sub_location',
      ));

      $this->addColumn('address', array(
          'header'    => Mage::helper('scan')->__('address'),
          'align'     =>'left',
          'index'     => 'address',
      ));

      $this->addColumn('status', array(
          'header'    => Mage::helper('scan')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enable',
              2 => 'Disable',
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

}