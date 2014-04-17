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
 * @package     Enterprise_UrlRewrite
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/* @var $this Mage_Core_Model_Resource_Setup */

// we should set valid entity_type to rewrite table after column entity_type appeared into url rewrite table
$select = $this->getConnection()->select()
    ->joinInner(
        array('rel' => $this->getTable('enterprise_urlrewrite/redirect_rewrite')),
        'ur.url_rewrite_id = rel.url_rewrite_id',
        array('entity_type' => new Zend_Db_Expr(Enterprise_UrlRewrite_Model_Redirect::URL_REWRITE_ENTITY_TYPE))
    );
$updateSql = $this->getConnection()->updateFromSelect(
    $select,
    array('ur' => $this->getTable('enterprise_urlrewrite/url_rewrite'))
);
$this->getConnection()->query($updateSql);

$select = $this->getConnection()->select()
    ->joinInner(
        array('rel' => $this->getTable('enterprise_catalog/category')),
        'ur.url_rewrite_id = rel.url_rewrite_id',
        array('entity_type' => new Zend_Db_Expr(Enterprise_Catalog_Model_Category::URL_REWRITE_ENTITY_TYPE))
    );
$updateSql = $this->getConnection()->updateFromSelect(
    $select,
    array('ur' => $this->getTable('enterprise_urlrewrite/url_rewrite'))
);
$this->getConnection()->query($updateSql);

$select = $this->getConnection()->select()
    ->joinInner(
        array('rel' => $this->getTable('enterprise_catalog/product')),
        'ur.url_rewrite_id = rel.url_rewrite_id',
        array('entity_type' => new Zend_Db_Expr(Enterprise_Catalog_Model_Product::URL_REWRITE_ENTITY_TYPE))
    );
$updateSql = $this->getConnection()->updateFromSelect(
    $select,
    array('ur' => $this->getTable('enterprise_urlrewrite/url_rewrite'))
);
$this->getConnection()->query($updateSql);
