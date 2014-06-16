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

class DC_Catalog_Model_Manufacturer extends Mage_Core_Model_Abstract
{

    const NOROUTE_PAGE_ID = 'no-route';

    protected $_eventPrefix = 'dc_catalog';

    protected function _construct()
    {
        $this->_init('dc_catalog/manufacturer');
    }

    public function load($id, $field=null)
    {
        if (is_null($id)) {
            return $this->noRoutePage();
        }
        return parent::load($id, $field);
    }

    public function loadFromAttribute($attribute_code, $option_id, $store_id)
    {
        $this->_getResource()->loadFromAttribute($this, $attribute_code, $option_id, $store_id);
        $this->_afterLoad();
        $this->setOrigData();
        return $this;
    }

    /**
     * Check if page identifier exist for specific store
     * return page id if page exists
     *
     * @param   string $identifier
     * @param   int $storeId
     * @return  int
     */
    public function checkIdentifierInPages($attribute_code, $identifier, $storeId)
    {
        return $this->_getResource()->checkIdentifierInPages($attribute_code, $identifier, $storeId);
    }

    /**
     * Check if page identifier exist for specific store
     * return page id if page exists
     *
     * @param   string $identifier
     * @param   int $storeId
     * @return  int
     */
    public function getOptionIdFromIdentifier($attribute_code, $identifier, $storeId)
    {
        return $this->_getResource()->getOptionIdFromIdentifier($attribute_code, $identifier, $storeId);
    }

    public function getImageUrl($field = 'image')
    {
        $url = false;
        if ($image = ('image' == $field ? $this->getImage() : $this->getBanner())) {
            $url = Mage::getBaseUrl('media').'catalog/attribute/'.$image;
        }
        return $url;
    }

}
