<?php

class Bms_Scan_Model_Scanprices extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('scan/scanprices');
    }
}