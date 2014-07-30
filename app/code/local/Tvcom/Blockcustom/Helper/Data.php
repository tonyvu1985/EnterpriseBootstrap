<?php
/**
 * Checkout default helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
require_once(Mage::getBaseDir().DS."app".DS."code".DS."core".DS."Mage".DS."Catalog".DS."Block".DS."Product.php");

class Tvcom_Blockcustom_Helper_Data extends Mage_Core_Helper_Abstract{
    /* get feature product list from their sku */
    public function getProducts($arry_product_sku){   
        $products = Mage::helper('mega/data')->getProductBySku($arry_product_sku);
	$product_block = new Mage_Catalog_Block_Product;
        $html .= '<ul>';
        foreach($products as $product){
           $html .=  '<li>';
           $html .=     '<div>';
           $html .=        '<a href="' . Mage::getBaseUrl(). $product->getUrl_path() . '" /><img src="' . Mage::helper('catalog/image')->init($product, 'small_image')->resize(150) . '" alt=""></a>';                             
           $html .=        '<p><a href="' . Mage::getBaseUrl(). $product->getUrl_path() . '">' . $product->getName() . '</a>';
           $html .=        '<p>' . $product_block->getPriceHtml($product) . '</p>';               
           $html .=    '</div>';
           $html .=  '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
    
}
