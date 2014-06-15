<?php

/**
 * define the Narbar style
 *
 */
 class Tvcom_Themecustom_Model_Option_Narbar
 {     
     public function toOptionArray()
     {
        return array(
            array('value'=>'navbar-default' , 'label'=>'default'),
            array('value'=>'navbar-inverse' , 'label'=>'inverse'),
        );      
     }
 }
