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
class DC_Catalog_Block_List_Favorites extends DC_Catalog_Block_List_All
{
    /**
     * @return DC_Catalog_Model_Mysql4_Manufacturer_Collection
     */
    public function getValuesCollection($randomize = false)
    {
        if (null === $this->_valuesCollection) {

	        //the attribute value collection
	        $this->_valuesCollection = Mage::getModel('dc_catalog/manufacturer')->getCollection();

	        //set the store id and the main category from the store
	        $this->_valuesCollection
	        	->addStoreFilter(Mage::app()->getStore()->getId(), true)
	        	->addAttributeCodeFilter($this->getAttributeCode())
	        	->addFavoritesFilter()
	        	->addEnabledFilter();

	        if ($randomize) {
		        $this->_valuesCollection->randomize();
	        }
        }
        return $this->_valuesCollection;
    }

    protected function _toHtml()
    {
        /*if ($toolbar = $this->getChild('toolbar')) {
            $toolbar->setCollection($this->getValuesCollection());
        }*/

        return parent::_toHtml();
    }

}
