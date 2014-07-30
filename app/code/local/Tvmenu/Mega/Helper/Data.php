<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once (Mage::getBaseDir().DS."app".DS."code".DS."core".DS."Mage".DS."Catalog".DS."Block".DS."Product.php");

class Tvmenu_Mega_Helper_Data extends Mage_Core_Helper_Abstract{  
   public function getSubCategories($parent_id){
    	return Mage::getModel("catalog/category")
    	->getCollection()
    	->addAttributeToSelect('name')
        ->addAttributeToSelect('url_path')                      
    	->addFieldToFilter('is_active', array('eq'=>'1'))
    	->addFieldToFilter('parent_id', array($parent_id))
    	->load();
    }
    
    public function getCategory($catId){
        return Mage::getModel('catalog/category')
                ->getCollection()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('url_path')
                ->addAttributeToSelect('description')
                ->addAttributeToSelect('image')
                ->addFieldToFilter('entity_id', array('eq' => $catId))
                ->addAttributeToFilter('is_active', 1)
                ->load();
    }
    
    public function getProductBySku($arry_product_sku){        
         return Mage::getModel("catalog/product")
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('status', 1)
            ->addAttributeToFilter('sku', array('in'=> $arry_product_sku))
                ->load();
    }
    
    public function getCatergorybyLevel($rootid) {
    	//load only location category
    	$categories = $this->getSubCategories($rootid);
        $i = 0; 
        $html .= '<div class="row">';
    	foreach ($categories as $cat) {
            $html .= '<ul class="col-md-3 col-sm-6 col-xs-12">';
            $html .= '<li><a href="' . Mage::getBaseurl() . $cat->getUrlpath() . '" class="title">' . $cat->getName() . '</a></li>';
            $children = $this->getSubCategories($cat->getEntityId());
            foreach ($children as $child) {
                    $html .= '<li><a href="' . Mage::getBaseurl() . $child->getUrlpath() . '">' . $child->getName() . '</a></li>';
            }
            $html .= '</ul>';
            $i++;
            if ($i % 4 == 0){
                $html .= '</div><div class="row">';  
            }
    	}
        $html .= '</div>';
    	return $html;
    }
    
    /* get feature product list from their sku */
    public function getFeaturedCategory($catId){ 
        $cats = $this->getCategory($catId);     
        $html .= '<div class="row">';
        // it s collection so we have to do foreach to get result
        foreach($cats as $cat){
           $html .= '<div class="col-md-6 col-sm-12">';
           $html .= '<img class="img-responsive" src="' . Mage::getStoreConfig('web/unsecure/base_url') . 'media/catalog/category/' . $cat->getImage() . '">';
           $html .= '</div>';
           $html .= '<div class="col-md-6 col-sm-12">';
           $html .=     '<p><a href="' . Mage::getBaseUrl(). $cat->getUrl_path(). '" class="title" alt="' . $cat->getName() . '">' . $cat->getName() . '</a></p>';      
           $html .=     '<p>' . $cat->getDescription() . '</p>';    
           $html .=     '<p><a href="' . Mage::getBaseUrl(). $cat->getUrl_path() . '" class="btn btn-default" alt="' . $cat->getName() . '">View Category</a></p>';    
           $html .= '</div>';
        }            
        $html .= '</div>';
        return $html;
    }
    
        /* get feature product list from their sku */
    public function getSaleProducts($arry_product_sku){        
        $products = $this->getProductBySku($arry_product_sku);        
        $html .= '<table class="table table-hover">';   
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th colspan="3" class="salelists">Sale Product List</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
	$product_block = new Mage_Catalog_Block_Product;
        foreach($products as $product){
           $html .= '<tr>';
           $html .= '<td align="left"><img src="' . Mage::helper('catalog/image')->init($product, 'small_image')->resize(40) . '" alt=""></td>';                             
           $html .= '<td><a href="' . Mage::getBaseUrl(). $product->getUrl_path() . '">' . $product->getName() . '</a></td>';
           $html .= '<td>' . $product_block->getPriceHtml($product) . '</td>';          
           $html .= '</tr>';
        }            
        $html .= '</tbody>';
        $html .= '</table>';
        return $html;
    }
    
     
                        
               
                            
                        
                       
                      
}
?>
