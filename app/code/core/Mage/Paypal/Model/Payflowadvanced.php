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
 * @package     Mage_Paypal
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Payments Advanced gateway model
 *
 * @category    Mage
 * @package     Mage_Paypal
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Paypal_Model_Payflowadvanced extends Mage_Paypal_Model_Payflowlink
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = Mage_Paypal_Model_Config::METHOD_PAYFLOWADVANCED;

    /**
     * Type of block that generates method form
     *
     * @var string
     */
    protected $_formBlockType = 'paypal/payflow_advanced_form';

    /**
     * Type of block that displays method information
     *
     * @var string
     */
    protected $_infoBlockType = 'paypal/payflow_advanced_info';

    /**
     * Controller for callback urls
     *
     * @var string
     */
    protected $_callbackController = 'payflowadvanced';
}
