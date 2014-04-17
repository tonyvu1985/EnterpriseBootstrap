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
 * Breadcrumbs container
 *
 * @deprecated after 1.12.0.2
 */
class Enterprise_PageCache_Model_Container_Breadcrumbs extends Enterprise_PageCache_Model_Container_Abstract
{
    /**
     * Get cache identifier
     *
     * @return string
     */
    protected function _getCacheId()
    {
        if ($this->_getCategoryId() || $this->_getProductId()) {
            $cacheSubKey = '_' . $this->_getCategoryId()
                . '_' . $this->_getProductId();
        } else {
            $cacheSubKey = $this->_getRequestId();
        }

        return 'CONTAINER_BREADCRUMBS_'
            . md5($this->_placeholder->getAttribute('cache_id') . $cacheSubKey);
    }

    /**
     * Render block content
     *
     * @return string
     */
    protected function _renderBlock()
    {
        $productId = $this->_getProductId();

        /** @var $product null|Mage_Catalog_Model_Product */
        $product = null;

        if ($productId) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product) {
                Mage::register('current_product', $product);
            }
        }
        $categoryId = $this->_getCategoryId();

        if ($product !== null && !$product->canBeShowInCategory($categoryId)) {
            $categoryId = null;
            Mage::unregister('current_category');
        }

        if ($categoryId && !Mage::registry('current_category')) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            if ($category) {
                Mage::register('current_category', $category);
            }
        }

        //No need breadcrumbs on CMS pages
        if (!$productId && !$categoryId) {
            return '';
        }

        /** @var $breadcrumbsBlock Mage_Page_Block_Html_Breadcrumbs */
        $breadcrumbsBlock = $this->_getPlaceHolderBlock();
        $breadcrumbsBlock->setNameInLayout('breadcrumbs');
        $crumbs = $this->_placeholder->getAttribute('crumbs');
        if ($crumbs) {
            $crumbs = unserialize(base64_decode($crumbs));
            foreach ($crumbs as $crumbName => $crumbInfo) {
                $breadcrumbsBlock->addCrumb($crumbName, $crumbInfo);
            }
        }
        Mage::dispatchEvent('render_block', array('block' => $breadcrumbsBlock, 'placeholder' => $this->_placeholder));
        return $breadcrumbsBlock->toHtml();
    }
}
