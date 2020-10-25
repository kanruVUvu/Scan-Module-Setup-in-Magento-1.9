<?php
class Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Feedbackinline extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    public function render(Varien_Object $row)
    {
        $html = parent::render($row);
        $html .= '<button style="margin: 5px 16px 0px 10px;" id="addFeedback'. $row->getId() .'">' . Mage::helper('adminhtml')->__('Update1') . '</button>';
        return $html;
    }
}