<?php
/* Set up link for Carousel */

class Tvcarousel_Slider_Block_Link extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function __construct()
    {
        $this->addColumn('image_name', array(
            'label' => Mage::helper('adminhtml')->__('Image Name'),
            'style' => 'width:130px',
        ));

        $this->addColumn('image_link', array(
            'label' => Mage::helper('adminhtml')->__('Image Link'),
            'style' => 'width:400px',
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add Link Banner');
        parent::__construct();
    }
}

