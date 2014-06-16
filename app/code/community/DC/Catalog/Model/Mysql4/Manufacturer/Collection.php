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

class DC_Catalog_Model_Mysql4_Manufacturer_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_previewFlag;

    protected function _construct()
    {
        $this->_init('dc_catalog/manufacturer');
        $this->_setIdFieldName('false_id');
    }

    public function toOptionArray()
    {
        return $this->_toOptionArray('identifier', 'name');
    }

    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }

    protected function _initSelect()
    {
        $allowedAttributes = explode(',', Mage::getStoreConfig('dc_catalog/attributes/selectedattributes'));
    	parent::_initSelect();

        $this->getSelect()
        	->joinRight(array('aov' => $this->getTable('eav/attribute_option_value')), 'aov.option_id = main_table.attribute_option_id AND aov.store_id = main_table.attribute_value_store_id', array('value_id', 'value', 'store_id', 'option_id'))
            ->join(     array('ao'  => $this->getTable('eav/attribute_option')),       'ao.option_id = aov.option_id', array())
            ->join(     array('a'   => $this->getTable('eav/attribute')),              'a.attribute_id = ao.attribute_id', array(
            																'attribute_code',
            																'frontend_label',
            														        //use a false_id column for having unique ids!
            														        'concat(a.attribute_code, ao.option_id, \'store\', aov.store_id) as false_id'
            															))
            ->where('a.attribute_code IN (?)', $allowedAttributes)
            ->where('SUBSTRING(aov.value,1,1) != \'-\'')
            ->order('value');

        return $this;
    }

    /**
     * Format URL key from name or defined key
     *
     * @param string $str
     * @return string
     */
    public static function formatUrlKey($str)
    {
        $str = Mage::helper('core')->removeAccents($str);
        $urlKey = preg_replace('#[^0-9a-z]+#i', '-', $str);
        $urlKey = strtolower($urlKey);
        $urlKey = trim($urlKey, '-');
        return $urlKey;
    }

    protected function _afterLoad()
    {
    	parent::_afterLoad();

    	foreach ($this->_items as $object) {
            if(!$object->getData('identifier'))         $object->setData('identifier', $this->formatUrlKey($object->getValue()));
        }

        return $this;
    }

    /**
     * Add Filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @return DC_Catalog_Model_Mysql4_Manufacturer_Collection
     */
    public function addStoreFilter($store, $allStores = false)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        if ($allStores && ($store > 0)) {
	        $this->getSelect()
		         ->where('(? in (aov.store_id, attribute_value_store_id)) OR (0 in (aov.store_id, attribute_value_store_id))', $store);
        } else {
	        $this->getSelect()
		         ->where('? in (aov.store_id, attribute_value_store_id)', $store);
        }
        return $this;
    }

    /**
     * Add Filter by attribute_code
     *
     * @param int|Mage_Core_Model_Store $store
     * @return DC_Catalog_Model_Mysql4_Manufacturer_Collection
     */
    public function addAttributeCodeFilter($attributeCode)
    {
        $this->getSelect()
        	 ->where('a.attribute_code = ?', $attributeCode);
        return $this;
    }

    /**
     * Add Filter for enabled
     *
     * @param int|Mage_Core_Model_Store $store
     * @return DC_Catalog_Model_Mysql4_Manufacturer_Collection
     */
    public function addEnabledFilter()
    {
    	//the disabled flag must be set explicit
    	//if there is no record in values table, it means it the value page is not created yet, so the default is 1
        $this->getSelect()->where('coalesce(main_table.is_active,1) > 0');
        return $this;
    }

    /**
     * Add Filter for favorites
     *
     * @param int|Mage_Core_Model_Store $store
     * @return DC_Catalog_Model_Mysql4_Manufacturer_Collection
     */
    public function addFavoritesFilter()
    {
        $this->getSelect()
        	->where('favorite > 0')
        	->reset( Zend_Db_Select::ORDER )
        	->order('favorite asc');
        return $this;
    }

    /**
     * Randomize the output
     *
     * @param int|Mage_Core_Model_Store $store
     * @return DC_Catalog_Model_Mysql4_Manufacturer_Collection
     */
    public function randomize()
    {
        $this->getSelect()
    		->reset( Zend_Db_Select::ORDER )
        	->order('rand()');
        return $this;
    }

    /**
     * Remove pagination, get all items
     *
     * @param int|Mage_Core_Model_Store $store
     * @return DC_Catalog_Model_Mysql4_Manufacturer_Collection
     */
    public function retrieveAll()
    {
        $this->setPageSize(false);

        //echo $this->getSelect();
        return $this;
    }


}
