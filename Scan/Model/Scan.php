<?php

class Bms_Scan_Model_Scan extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('scan/scan');
    }
}