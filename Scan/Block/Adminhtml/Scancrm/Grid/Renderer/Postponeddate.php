<?php

class Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Postponeddate extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }

    public function _getValue(Varien_Object $row)
    {
        $val = $row->getData($this->getColumn()->getIndex());  // row value
       
		$currentTimestamp = Mage::getModel('core/date')->timestamp(time());
		$date = date('Y-m-d H:i:s', $currentTimestamp);
		$now = new DateTime($date);
		$postponed = new DateTime($val);
		
		$dteDiff  = $now->diff($postponed); 

		//echo $dteDiff->format('%Y-%m-%d %H:%i:%s'); 
		$today=$dteDiff->format('%Y-%m-%d %H');
		//echo $today;
	
        if($today=='00-0-0 00'){
			$newformat="<span style='color:blue'><b>".$val."</b></span>";
		}
		else{
			$newformat=$val;
		}
       
        return $newformat;
		

    }

}
