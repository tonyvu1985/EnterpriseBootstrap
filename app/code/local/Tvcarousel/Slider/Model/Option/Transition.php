<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tvcarousel_Slider_Model_Option_Transition{
    public function toOptionArray(){
        return array(
            array('value'=>'slide', 'label'=>'slide'),
            array('value'=>'slide carousel-fade', 'label'=>'fade'),
        );
    }
}
?>
