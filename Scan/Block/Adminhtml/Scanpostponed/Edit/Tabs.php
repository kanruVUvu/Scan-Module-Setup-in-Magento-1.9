<?php

class Bms_Scan_Block_Adminhtml_Scanpostponed_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('scanpostponed_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('scan')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('scan')->__('Item Information'),
          'title'     => Mage::helper('scan')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('scan/adminhtml_scanpostponed_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}