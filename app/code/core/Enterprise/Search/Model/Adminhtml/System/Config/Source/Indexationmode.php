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
 * @package     Enterprise_Search
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


/**
 * Search engine indexation modes
 *
 * @category    Enterprise
 * @package     Enterprise_Search
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Search_Model_Adminhtml_System_Config_Source_Indexationmode
{
    /**
     * Prepare options for selection
     *
     * @return array
     */
    public function toOptionArray()
    {
        $modes = array(
            Enterprise_Search_Model_Indexer_Indexer::SEARCH_ENGINE_INDEXATION_COMMIT_MODE_FINAL    =>
                Mage::helper('enterprise_search')->__('Final commit'),
            Enterprise_Search_Model_Indexer_Indexer::SEARCH_ENGINE_INDEXATION_COMMIT_MODE_PARTIAL  =>
                Mage::helper('enterprise_search')->__('Partial commit'),
            Enterprise_Search_Model_Indexer_Indexer::SEARCH_ENGINE_INDEXATION_COMMIT_MODE_ENGINE   =>
                Mage::helper('enterprise_search')->__('Engine autocommit')
        );

        $options = array();
        foreach ($modes as $value => $label) {
            $options[] = array(
                'value' => $value,
                'label' => $label
            );
        }

        return $options;
    }
}
