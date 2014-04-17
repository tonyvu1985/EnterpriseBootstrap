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
 * @package     Enterprise_Wishlist
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Wishlist delete button
 *
 * @category    Enterprise
 * @package     Enterprise_Wishlist
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Wishlist_Block_Customer_Wishlist_Button_Delete extends Mage_Wishlist_Block_Abstract
{
    /**
     * Build block html
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (Mage::helper('enterprise_wishlist')->isMultipleEnabled() && $this->isWishlistDeleteable()) {
            return parent::_toHtml();
        }
        return '';
    }

    /**
     * Check whether current wishlist can be deleted
     *
     * @return bool
     */
    protected function isWishlistDeleteable()
    {
        return !Mage::helper('enterprise_wishlist')->isWishlistDefault($this->getWishlistInstance());
    }

    /**
     * Build wishlist deletion url
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('wishlist/index/deletewishlist', array('wishlist_id' => '%item%'));
    }

    /**
     * Retrieve url to redirect customer to after wishlist is deleted
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->getUrl('wishlist/index/index');
    }
}
