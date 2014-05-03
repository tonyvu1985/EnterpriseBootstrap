<?php

/*
 * Author: Tony Vu
 * Description: use bootstrap Badges in the toplinks
 */
class Tvcom_Wishlist_Block_Links extends Mage_Wishlist_Block_Links{
    protected function _createLabel($count){
        if ($count >= 1) {
            return $this->__("<i class='wishlist-icon fa fa-gift'></i> <span class='wishlist-text'>My Wishlist</span> %d", $count);
        } else {
            return $this->__("<i class='wishlist-icon fa fa-gift'></i> <span class='wishlist-text'>My Wishlist</span>");
        }
    }
   
}
?>