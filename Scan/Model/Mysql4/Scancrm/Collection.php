<?php

class Bms_Scan_Model_Mysql4_Scancrm_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('scan/scancrm');
    }
}