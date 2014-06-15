<?php

/**
 * define the background repeat status
 *
 */
 class Tvcom_Themecustom_Model_Option_Footerlayout 
 {     
     public function toOptionArray()
     {
        return array(
            array('value'=>'one_column' , 'label'=>'1 column'),
            array('value'=>'two_columns', 'label'=>'2 columns'),
        );      
     }
 }
