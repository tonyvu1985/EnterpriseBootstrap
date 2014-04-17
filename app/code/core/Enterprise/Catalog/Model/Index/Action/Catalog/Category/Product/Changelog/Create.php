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

/**
 * Changelog create action class
 *
 * @category    Enterprise
 * @package     Enterprise_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Catalog_Model_Index_Action_Catalog_Category_Product_Changelog_Create
    extends Enterprise_Mview_Model_Action_Changelog_Create
{
    /**
     * Constructor with parameters
     * Array of arguments with keys
     *  - 'table_name' string. The name of existing table
     *  - 'key_column' string. The name of key column
     *
     * @param array $args
     * @throws InvalidArgumentException
     */
    public function __construct(array $args)
    {
        parent::__construct($args);
        if (empty($args['table_name'])) {
            throw new InvalidArgumentException('Table Name is missing');
        }
        $this->_table = $this->_factory->getMagentoDbObjectTable($this->_connection,
            $args['table_name']);
    }
}
