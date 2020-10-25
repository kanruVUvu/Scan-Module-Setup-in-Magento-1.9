<?php

class Bms_Scan_Block_Adminhtml_Scancrm_Grid_Renderer_Sendemail extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
//        echo $row->getId();
        $model = Mage::getModel('scan/scancrm')->load($row->getId());
        

        if($model->getPrice()==0){
        	 return '<a href="'.Mage::helper('adminhtml')->getUrl('scan/adminhtml_scancompleted/sendinvoicemail/id/'.$row->getId(), array('_secure' => true)).'">Send Mail</a>';
        }else{
            return "";
        }
    }

}