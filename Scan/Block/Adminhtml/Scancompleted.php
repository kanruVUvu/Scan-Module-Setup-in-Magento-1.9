<?php
class Bms_Scan_Block_Adminhtml_Scancompleted extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_scancompleted';
    $this->_blockGroup = 'scan';
    $this->_headerText = Mage::helper('scan')->__('Manage Completed Scan');
    $this->_addButtonLabel = Mage::helper('scan')->__('Add Item');
    parent::__construct();
  }
}