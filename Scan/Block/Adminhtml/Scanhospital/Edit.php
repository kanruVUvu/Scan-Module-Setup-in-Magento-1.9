<?php

class Bms_Scan_Block_Adminhtml_Scanhospital_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'scan';
        $this->_controller = 'adminhtml_scanhospital';
        
        $this->_updateButton('save', 'label', Mage::helper('scan')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('scan')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('scanhospital_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'scanhospital_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'scanhospital_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('scanhospital_data') && Mage::registry('scanhospital_data')->getId() ) {
            return Mage::helper('scan')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('scanhospital_data')->getId()));
        } else {
            return Mage::helper('scan')->__('Add Item');
        }
    }

    // public function history() {
        // if($this->getRequest()->getParam('id')){
            // $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
            // $sql = "SELECT * FROM `bs_historymap` where cid = " . $this->getRequest()->getParam('id')." AND enq_type='scan' order by id desc";
            // $rows = $connection->fetchAll($sql);
            
            // $history = '<h3>Followup History Mapping</h3><table class="arigrid"><tr><th>Updated By</th><th>Updated Time</th><th>Coupon Code</th><th>Customer Name</th><th>Status</th><th>Comments</th></tr>';
            // foreach ($rows as $values) {
                // $history .= '<tr><td>'.$values['updated_by'].'</td><td>'.$values['time'].'</td><td>'.$values['coupon_code'].'</td><td>'.$values['name'].'</td><td>'.$values['status'].'</td><td>'.$values['follow_comments'].'</td></tr>';
            // }
            // $history .= '</table>';
            // return $history;//$rows[0]['coupon_code']
        // }
    // }

     // protected function _toHtml() {
        // $tabsContainer = $this->getLayout()->createBlock('core/text', 'example-block');
        // return parent::_toHtml() . $tabsContainer->toHtml() . $this->history();
    // }
}