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

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$tableName = $installer->getTable('wishlist/wishlist');

$installer->getConnection()->dropForeignKey(
    $tableName,
    $installer->getFkName('wishlist/wishlist', 'customer_id', 'customer/entity', 'entity_id')
);
$installer->getConnection()->dropIndex(
    $tableName,
    $installer->getIdxName('wishlist/wishlist', 'customer_id', Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
);

$installer->getConnection()->addIndex(
    $tableName,
    $installer->getIdxName('wishlist/wishlist', 'customer_id', Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX),
    'customer_id',
    Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
);
$installer->getConnection()->addForeignKey(
    $installer->getFkName('wishlist/wishlist', 'customer_id', 'customer/entity', 'entity_id'),
    $tableName,
    'customer_id',
    $installer->getTable('customer/entity'),
    'entity_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
);

$installer->getConnection()->addColumn($tableName, 'name', array(
        'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'   => 255,
        'comment'  => 'Wishlist name',
        'default'  => null
    )
);

$installer->getConnection()->addColumn($tableName, 'visibility', array(
        'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => true,
        'default'  => 0,
        'comment'  => 'Wish list visibility type'
    )
);
