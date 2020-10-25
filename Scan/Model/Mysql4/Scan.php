<?php

class Bms_Scan_Model_Mysql4_Scan extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the surgery_id refers to the key field in your database table.
        $this->_init('scan/scan', 'scan_id');
    }
}