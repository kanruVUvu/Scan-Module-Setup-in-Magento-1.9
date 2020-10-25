<?php

class Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Hospitals extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
//        echo $row->getId();
        $model = Mage::getModel('scan/scancrm')->load($row->getId());
        

        if($model->getHospital()!=""){
        	$location = Mage::getModel('scan/scanhospital')->load($model->getHospital());
            return $location->getHospitalName().' ('.$location->getSubLocation().')';
        }else{
            return "";
        }
    }

}