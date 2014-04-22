<?php
/**
/**
 *
 * @author      Tony Vu <vuductrung2003.com>
 */
class Tvcom_Page_Block_Html_Welcome extends Mage_Page_Block_Html_Welcome
{
    /**
     * Get block messsage
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (empty($this->_data['welcome'])) {
            if (Mage::isInstalled() && Mage::getSingleton('customer/session')->isLoggedIn()) {
                $this->_data['welcome'] = $this->__('Hi, %s!', $this->escapeHtml(Mage::getSingleton('customer/session')->getCustomer()->getName()));
            } else {
                $this->_data['welcome'] = Mage::getStoreConfig('design/header/welcome');
            }
        }

        return $this->_data['welcome'];
    }
   
}
