<?php
/**
 * Checkout default helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Tvcom_Blockcustom_Helper_Data extends Mage_Core_Helper_Abstract{
    /* get feature product list from their sku */
    public function getProducts($arry_product_sku){   
        $products = Mage::helper('mega/data')->getProductBySku($arry_product_sku);
        $html .= '<ul>';
        foreach($products as $product){
           $html .=  '<li>';
           $html .=     '<div>';
           $html .=        '<a href="' . Mage::getBaseUrl(). $product->getUrl_path() . '" /><img src="' . Mage::helper('catalog/image')->init($product, 'small_image')->resize(150) . '" alt=""></a>';                             
           $html .=        '<p><a href="' . Mage::getBaseUrl(). $product->getUrl_path() . '">' . $product->getName() . '</a>';
           $html .=        '<p>' . Mage::helper('core')->currency($product->getPrice()) . '</p>';               
           $html .=    '</div>';
           $html .=  '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
    
}