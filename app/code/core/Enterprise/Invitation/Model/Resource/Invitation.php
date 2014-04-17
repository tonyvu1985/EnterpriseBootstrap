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
 * @package     Enterprise_Invitation
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


/**
 * Invitation data resource model
 *
 * @category    Enterprise
 * @package     Enterprise_Invitation
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Invitation_Model_Resource_Invitation extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Intialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('enterprise_invitation/invitation', 'invitation_id');
        $this->addUniqueField(array(
            'field' => array('customer_id', 'email'),
            'title' => Mage::helper('enterprise_invitation')->__('Invitation for same email address')
        ));
    }

    /**
     * Save invitation tracking info
     *
     * @param int $inviterId
     * @param int $referralId
     */
    public function trackReferral($inviterId, $referralId)
    {
        $data = array(
                'inviter_id'  => (int)$inviterId,
                'referral_id' => (int)$referralId
            );
        $this->_getWriteAdapter()->insertOnDuplicate(
            $this->getTable('enterprise_invitation/invitation_track'),
            $data,
            array_keys($data)
        );
    }
}
