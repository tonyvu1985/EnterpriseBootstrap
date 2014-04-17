<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Enterprise
 * @package     Enterprise_PageCache
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Giftcard container
 *
 * @category   Enterprise
 * @package    Enterprise_PageCache
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_PageCache_Model_Container_Giftcard extends Enterprise_PageCache_Model_Container_Customer
{
    /**
     * Get identifier from cookies
     *
     * @return string
     */
    protected function _getIdentifier()
    {
        return $this->_getCookieValue(Enterprise_PageCache_Model_Cookie::COOKIE_CUSTOMER, '');
    }

    /**
     * Get cache identifier
     *
     * @return string
     */
    protected function _getCacheId()
    {
        return 'CONTAINER_GIFTCARD_'
            . md5($this->_placeholder->getAttribute('cache_id')
                . '_' . $this->_getProductId()
                . $this->_getIdentifier()
            );
    }

    /**
     * Render block content
     *
     * @return string
     */
    protected function _renderBlock()
    {
        $block = $this->_placeholder->getAttribute('block');
        $template = $this->_placeholder->getAttribute('template');

        /** @var $block Enterprise_GiftCard_Block_Catalog_Product_View_Type_Giftcard_Form */
        $block = new $block;
        $block->setTemplate($template);

        $productId = $this->_getProductId();

        $emailNeeded = $this->_loadCache($productId . '_email_needed');

        if ($emailNeeded === false) {
            /** @var $product Mage_Catalog_Model_Product */
            $product = Mage::getModel('catalog/product')
                ->load($productId);
            $emailNeeded = (int) !$product->getTypeInstance()->isTypePhysical();
            $this->_saveCache($emailNeeded, $productId . '_email_needed');
        }

        $block->setEmailNeeded($emailNeeded);

        return $block->toHtml();
    }
}
