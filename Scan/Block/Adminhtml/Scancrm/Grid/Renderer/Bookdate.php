<?php

class Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Bookdate extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }

    public function _getValue(Varien_Object $row)
    {
        $val = $row->getData($this->getColumn()->getIndex());  // row value
        $dateval = strtotime($val);
        $newformat = date('Y-m-d H:i:s',$dateval);
        //$date_val = date_format($val, 'd/M/Y H:i:s');
        //Mage::log($newformat);
        return $newformat;

    }

}
