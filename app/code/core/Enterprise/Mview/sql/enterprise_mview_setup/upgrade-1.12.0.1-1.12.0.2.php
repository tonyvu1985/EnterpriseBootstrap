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
 * @package     Enterprise_Mview
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/* @var $this Mage_Core_Model_Resource_Setup */
///////////////////////////////////////////
// Create table 'mview/metadata_group'
///////////////////////////////////////////
$table = $this->getConnection()
    ->newTable($this->getTable('enterprise_mview/metadata_group'))
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Mview metadata group id')
    ->addColumn('group_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
    ), 'Mview Metadata Group Code')
    ->addIndex($this->getIdxName('enterprise_mview/metadata_group', array('group_code'),
        Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('group_code'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->setComment('Mview metadata groups');

$this->getConnection()->createTable($table);

$this->getConnection()
    ->addColumn($this->getTable('enterprise_mview/metadata'), 'group_id',
        array(
            'comment'   => 'Mview metadata group id',
            'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'unsigned'  => true,
            'nullable'  => true
        )
    );

$this->getConnection()->addIndex(
    $this->getTable('enterprise_mview/metadata'),
    $this->getIdxName('enterprise_mview/metadata', array('group_id')),
    array('group_id')
);

$this->getConnection()
    ->addForeignKey(
        $this->getFkName('enterprise_mview/metadata', 'group_id',
            'enterprise_mview/metadata_group', 'group_id'),
        $this->getTable('enterprise_mview/metadata'),
        'group_id',
        $this->getTable('enterprise_mview/metadata_group'),
        'group_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );
