<?php

/**
 * define the background repeat status
 *
 */
 class Tvcom_Themecustom_Model_Option_Repeat 
 {     
     public function toOptionArray()
     {
        return array(
            array('value'=>'repeat'     , 'label'=>'repeat'),
            array('value'=>'repeat-x'   , 'label'=>'repeat-x'),
            array('value'=>'repeat-y'   , 'label'=>'repeat-y'),
            array('value'=>'no-repeat'  , 'label'=>'no-repeat'),
            array('value'=>'inherit'    , 'label'=>'inherit'),
        );      
     }
 }
