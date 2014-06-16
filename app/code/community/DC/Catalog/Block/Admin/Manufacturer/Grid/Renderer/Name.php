<?php
/**
 * Dot Collective - Magento Output 2009
 * Find more about Attribute Info Pages:
 * http://dot.collective.ro/magento-output/magento-shop-by-manufacturer-brand-character-attribute-info-pages/
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   DC
 * @package    DC_Catalog
 * @copyright  Copyright (c) 2009 Dot Collective SRL http://dot.collective.ro
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DC_Catalog_Block_Admin_Manufacturer_Grid_Renderer_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if ($row->getData('attribute_page_id') > 0) {
        	return $row->getData('name');
        }
        return '<i style="font-size: smaller; color: #999">Click to add info</i>';
    }
}