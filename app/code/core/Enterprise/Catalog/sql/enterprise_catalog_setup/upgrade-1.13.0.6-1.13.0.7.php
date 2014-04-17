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
 * @package     Enterprise_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/* @var $this Mage_Core_Model_Resource_Setup */

$events       = array();
$eventRecords = Mage::getModel('enterprise_mview/event')->getCollection()->load();

foreach ($eventRecords as $event) {
    $events[$event->getName()] = $event->getMviewEventId();
}

//Flat system triggers subscriptions
/* @var $indexHelper Enterprise_Index_Helper_Data */
$indexHelper = Mage::helper('enterprise_index');
$eventsMetadataMapping = array(
    'catalog_url_category' => array(
        'add_store',
    ),
);

$metadataModel = Mage::getModel('enterprise_mview/metadata');

$indexTable = $this->getTable($indexHelper->getIndexTableByIndexerName('catalog_url_category'));

foreach ($eventsMetadataMapping['catalog_url_category'] as $eventName) {
    if (isset($events[$eventName])) {
        $data = array(
            'mview_event_id' => $events[$eventName],
            'metadata_id'    => $metadataModel->load($indexTable, 'table_name')->getId()
        );

        $this->getConnection()->insert($this->getTable('enterprise_mview/metadata_event'), $data);
    }
}


