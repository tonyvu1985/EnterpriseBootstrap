<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tvcarousel_Slider_Helper_Data extends Mage_Core_Helper_Abstract{
	public function getImageName($path_image){
                return substr($path_image, strrpos($path_image, '/') + 1);
        }
    
}

?>
