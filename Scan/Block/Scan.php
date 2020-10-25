<?php
class Bms_Scan_Block_Scan extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getScan()     
     { 
        if (!$this->hasData('scan')) {
            $this->setData('scan', Mage::registry('scan'));
        }
        return $this->getData('scan');
        
    }
}