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

class DC_Catalog_Model_Mysql4_Config_Attributes extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('dc_catalog/config_attributes', 'attribute_id');
    }

    public function getAttributes()
    {
        $read = $this->_getReadAdapter();
        $data = null;

        if ($read) {

        	/**
        	 * gets the list of all attributes that are dropdown and have options
        	 */
			$select = $read->select()
				->from(array('a'   => $this->getTable('eav/attribute')),              array('attribute_code', 'frontend_label'))
				->join(array('ao'  => $this->getTable('eav/attribute_option')),       'a.attribute_id = ao.attribute_id', array())
				->order('frontend_label')
				;

            $data = $read->fetchPairs($select);
        }

        return $data;
    }


}