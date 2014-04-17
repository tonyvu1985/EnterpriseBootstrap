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
 * @category    Mage
 * @package     Mage_XmlConnect
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Admin application login form renderer
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Adminhtml_Connect_Loginform extends Mage_Core_Block_Abstract
{
    /**
     * Render login form xml
     *
     * @return string
     */
    protected function _toHtml()
    {
        $action = $this->getUrl('*/*/login');

        /** @var Mage_XmlConnect_Model_Simplexml_Form $fromXmlObj */
        $fromXmlObj = Mage::getModel('xmlconnect/simplexml_form', array(
            'xml_id' => 'login_form',
            'action' => $action,
            'use_container' => true
        ))->setFieldNameSuffix('login_info');

        $formFieldset = $fromXmlObj->addFieldset('account_info', array(
            'title' => $this->__('Log in to Admin Panel')
        ));

        $formFieldset->addField('username', 'text', array(
            'label' => $this->__('User Name:'),
            'name'  => 'username',
            'required' => 1
        ));

        $formFieldset->addField('password', 'password', array(
            'label' => $this->__('Password:'),
            'name'  => 'password',
            'required' => 1
        ));

        return $fromXmlObj->getXml();
    }
}
