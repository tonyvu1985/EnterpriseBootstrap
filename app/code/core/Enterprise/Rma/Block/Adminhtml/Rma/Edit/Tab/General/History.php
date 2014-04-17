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
 * @package     Enterprise_Rma
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Comments History Block at RMA page
 *
 * @category   Enterprise
 * @package    Enterprise_Rma
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Rma_Block_Adminhtml_Rma_Edit_Tab_General_History
    extends Enterprise_Rma_Block_Adminhtml_Rma_Edit_Tab_General_Abstract
{
    /**
     * Prepare child blocks
     *
     * @return Enterprise_Rma_Block_Adminhtml_Rma_Edit_Tab_General_History
     */
    protected function _prepareLayout()
    {
        $onclick = "submitAndReloadArea($('rma-history-block').parentNode, '".$this->getSubmitUrl()."')";
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label'   => Mage::helper('enterprise_rma')->__('Submit Comment'),
                'class'   => 'save',
                'onclick' => $onclick
            ));
        $this->setChild('submit_button', $button);

        return parent::_prepareLayout();
    }

    /**
     * Get config value - is Enabled RMA Comments Email
     *
     * @return bool
     */
    public function canSendCommentEmail()
    {
        /** @var $configRmaEmail Enterprise_Rma_Model_Config */
        $configRmaEmail = Mage::getSingleton('enterprise_rma/config');
        $configRmaEmail->init($configRmaEmail->getRootCommentEmail(), $this->getOrder()->getStore());
        return $configRmaEmail->isEnabled();
    }

    /**
     * Get config value - is Enabled RMA Email
     *
     * @return bool
     */
    public function canSendConfirmationEmail()
    {
        /** @var $configRmaEmail Enterprise_Rma_Model_Config */
        $configRmaEmail = Mage::getSingleton('enterprise_rma/config');
        $configRmaEmail->init($configRmaEmail->getRootRmaEmail(), $this->getOrder()->getStore());
        return $configRmaEmail->isEnabled();
    }

    /**
     * Get URL to add comment action
     *
     * @return string
     */
    public function getSubmitUrl()
    {
        return $this->getUrl('*/*/addComment', array('id'=>$this->getRmaData('entity_id')));
    }

    public function getComments() {
        return Mage::getResourceModel('enterprise_rma/rma_status_history_collection')
            ->addFieldToFilter('rma_entity_id', Mage::registry('current_rma')->getId());
    }

}
