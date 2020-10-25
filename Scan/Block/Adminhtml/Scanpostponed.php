<?php
class Bms_Scan_Block_Adminhtml_Scanpostponed extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_scanpostponed';
    $this->_blockGroup = 'scan';
    $this->_headerText = Mage::helper('scan')->__('Manage Postponed Scan');
    $this->_addButtonLabel = Mage::helper('scan')->__('Add Item');
    parent::__construct();
	
	$this->_removeButton('add');
  }
}