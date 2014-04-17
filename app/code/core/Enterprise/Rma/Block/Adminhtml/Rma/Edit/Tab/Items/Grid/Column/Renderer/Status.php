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
 * Grid column widget for rendering status grid cells
 *
 * @category    Enterprise
 * @package     Enterprise_Rma
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Rma_Block_Adminhtml_Rma_Edit_Tab_Items_Grid_Column_Renderer_Status
    extends Enterprise_Rma_Block_Adminhtml_Rma_Edit_Tab_Items_Grid_Column_Renderer_Abstract
{
    /**
     * Renders status column when it is editable
     *
     * @param   Varien_Object $row
     * @return  string
     */
    protected function _getEditableView(Varien_Object $row)
    {
        $options = $this->getStatusManager()->getAllowedStatuses();

        $selectName = 'items[' . $row->getId() . '][' . $this->getColumn()->getId() . ']';
        $html = '<select name="'. $selectName .'" class="action-select required-entry">';
        $value = $row->getData($this->getColumn()->getIndex());
        $html.= '<option value=""></option>';
        foreach ($options as $val => $label){
            $selected = ( ($val == $value && (!is_null($value))) ? ' selected="selected"' : '' );
            $html.= '<option value="' . $val . '"' . $selected . '>' . $label . '</option>';
        }
        $html.='</select>';
        return $html;
    }
}
