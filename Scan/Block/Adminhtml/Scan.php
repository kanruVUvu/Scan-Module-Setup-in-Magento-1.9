<?php
class Bms_Scan_Block_Adminhtml_Scan extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_scan';
    $this->_blockGroup = 'scan';
    $this->_headerText = Mage::helper('scan')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('scan')->__('Add Item');
    parent::__construct();
  }
}