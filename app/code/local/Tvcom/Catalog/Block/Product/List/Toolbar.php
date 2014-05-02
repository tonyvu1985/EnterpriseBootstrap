<?php
/**
 * Tony Vu (vuductrung2003@gmail.com)
 */

class Tvcom_Catalog_Block_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar 
{
    public function getLimit()
    {
        // show all products on category page
        $limit = 'all';
        
        return $limit;
    }

}
