<?php
class Bms_Scan_Block_Adminhtml_Scanprices extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_scanprices';
    $this->_blockGroup = 'scan';
    $this->_headerText = Mage::helper('scan')->__('Manage Scan Price List');
    $this->_addButtonLabel = Mage::helper('scan')->__('Add Item');
    parent::__construct();
  }
}