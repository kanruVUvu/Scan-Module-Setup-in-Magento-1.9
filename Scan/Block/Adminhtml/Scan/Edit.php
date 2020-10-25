<?php

class Bms_Scan_Block_Adminhtml_Scan_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'scan';
        $this->_controller = 'adminhtml_scan';
        
        $this->_updateButton('save', 'label', Mage::helper('scan')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('scan')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('scan_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'scan_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'scan_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('scan_data') && Mage::registry('scan_data')->getId() ) {
            return Mage::helper('scan')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('scan_data')->getId()));
        } else {
            return Mage::helper('scan')->__('Add Item');
        }
    }
}