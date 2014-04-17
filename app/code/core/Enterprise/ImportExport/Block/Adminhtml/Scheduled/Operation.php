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
 * @package     Enterprise_ImportExport
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Scheduled operation grid container
 *
 * @category    Enterprise
 * @package     Enterprise_ImportExport
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_ImportExport_Block_Adminhtml_Scheduled_Operation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Initialize block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_addButtonLabel = Mage::helper('enterprise_importexport')->__('Add Scheduled Export');

        $this->_addButton('add_new_import', array(
            'label'   => Mage::helper('enterprise_importexport')->__('Add Scheduled Import'),
            'onclick' => "setLocation('" . $this->getUrl('*/*/new', array('type' => 'import')) . "')",
            'class'   => 'add'
        ));

        $this->_blockGroup = 'enterprise_importexport';
        $this->_controller = 'adminhtml_scheduled_operation';
        $this->_headerText = Mage::helper('enterprise_importexport')->__('Scheduled Import/Export');
    }

    /**
     * Get create url
     *
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new', array('type' => 'export'));
    }
}
