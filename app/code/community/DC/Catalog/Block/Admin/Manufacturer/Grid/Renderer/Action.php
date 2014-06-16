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
class DC_Catalog_Block_Admin_Manufacturer_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	$storeId = null === $row->getData('attribute_value_store_id') ? $row->getData('store_id') : $row->getData('attribute_value_store_id');
		if ($row->getData('attribute_page_id') > 0) {
			$identifier = $row->getData('identifier');
		} else {
			$identifier = DC_Catalog_Model_Mysql4_Manufacturer::formatUrlKey($row->getData('value'));
		}
        $urlModel = Mage::getModel('core/url')->setStore($storeId);
        $href = $urlModel->getUrl($row->getData('attribute_code').'/'.$identifier, array('_current'=>false, '___store'=>$storeId));
        return '<a href="'.$href.'" target="_blank">'.$this->__('Preview').'</a>';
    }
}