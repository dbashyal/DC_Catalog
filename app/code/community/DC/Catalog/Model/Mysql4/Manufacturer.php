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

class DC_Catalog_Model_Mysql4_Manufacturer extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('dc_catalog/manufacturer', 'attribute_page_id');
    }

    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
		//force identifier to be URL friendly
    	$object->setData('identifier', $this->formatUrlKey($object->getIdentifier()));

        if (!$this->getIsUniqueIdentifier($object)) {
            Mage::throwException(Mage::helper('dc_catalog')->__('This Identifier already exists in the store. Please check for orphan Attribute Info pages (and delete old ones) by filtering the grid listing on the Option ID column.
            <br/>NOTE: If you entered a lot of text in the fields, be sure to copy it to the clipboard so that it\'s not wasted because of this error.'));
        }

        if ($this->isNumericIdentifier($object)) {
            Mage::throwException(Mage::helper('dc_catalog')->__('The Identifier cannot consist only of numbers.'));
        }

        //process images upload
        $value = $object->getData('image');
        $path = Mage::getBaseDir('media') . DS . 'catalog' . DS . 'attribute' . DS;
        if (is_array($value) && !empty($value['delete'])) {
	            //remove the file
	            unlink($path . $value['value']);
	            $object->setData('image', '');
        } else {
        	$uploaded = false;
        	try {
	        	//try to make the uplaod
	            $uploader = new Varien_File_Uploader('image');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	            $uploader->setAllowRenameFiles(true);
	            $uploader->save($path);
	            if (($uploaded = $uploader->getUploadedFileName()) > '') {
	            	$object->setData('image', $uploaded);
	            }
	        } catch (Exception $e) {
	            /** @TODO ??? */
	        }
        	if (!$uploaded && is_array($value) && isset($value['value'])) {
            	$object->setData('image', basename($value['value']));
        	}
        }

        $value = $object->getData('banner');
        if (is_array($value) && !empty($value['delete'])) {
	            //remove the file
	            unlink($path . $value['value']);
	            $object->setData('banner', '');
        } else {
        	$uploaded = false;
        	try {
	        	//try to make the uplaod
	            $uploader = new Varien_File_Uploader('banner');
        		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	            $uploader->setAllowRenameFiles(true);
	            $uploader->save($path);
	            if (($uploaded = $uploader->getUploadedFileName()) > '') {
		            $object->setData('image', $uploaded);
	            }
	        } catch (Exception $e) {
	            /** @TODO ??? */
	        }
        	if (!$uploaded && is_array($value) && isset($value['value'])) {
	            $object->setData('banner', basename($value['value']));
        	}
        }

    	$format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        foreach (array('custom_theme_from', 'custom_theme_to') as $dataKey) {
            if ($date = $object->getData($dataKey)) {
                $object->setData($dataKey, Mage::app()->getLocale()->date($date, $format, null, false)
                    ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT)
                );
            }
            else {
                $object->setData($dataKey, new Zend_Db_Expr('NULL'));
            }
        }

        if (! $object->getId()) {
            $object->setCreationTime(Mage::getSingleton('core/date')->gmtDate());
        }

        $object->setUpdateTime(Mage::getSingleton('core/date')->gmtDate());
        return $this;
    }

    public function load(Mage_Core_Model_Abstract $object, $value, $field=null)
    {
        $read = $this->_getReadAdapter();
        if ($read && !is_null($value)) {
			$select = $read->select()
				->from(array('main_table' => $this->getMainTable()))
				->joinLeft( array('aov' => $this->getTable('eav/attribute_option_value')), 'aov.option_id = main_table.attribute_option_id AND aov.store_id = main_table.attribute_value_store_id', array('value_id', 'value', 'store_id', 'option_id'))
				->join(     array('ao'  => $this->getTable('eav/attribute_option')),       'ao.option_id = aov.option_id', array())
				->join(     array('a'   => $this->getTable('eav/attribute')),              'a.attribute_id = ao.attribute_id', array('attribute_code', 'frontend_label'))

				->where('main_table.attribute_page_id = ?', $value)
            	->where('SUBSTRING(aov.value,1,1) != \'-\'')
				;

            $data = $read->fetchRow($select);

            if ($data) {
                $object->setData($data);
            }
        }

        $this->_afterLoad($object);

        return $this;

    	/*if (strcmp($value, (int)$value) !== 0) {
            $field = 'identifier';
        }
        return parent::load($object, $value, $field);*/
    }

    public function loadFromAttribute(Mage_Core_Model_Abstract $object, $attribute_code = null, $option_id = null, $store_id = null)
    {
        $read = $this->_getReadAdapter();
        if ($read && !is_null($attribute_code)) {
			$select = $read->select()
				->from(array('main_table' => $this->getMainTable()))
				->joinRight(array('aov' => $this->getTable('eav/attribute_option_value')), 'aov.option_id = main_table.attribute_option_id AND aov.store_id = main_table.attribute_value_store_id', array('value_id', 'value', 'store_id', 'option_id'))
				->join(     array('ao'  => $this->getTable('eav/attribute_option')),       'ao.option_id = aov.option_id', array())
				->join(     array('a'   => $this->getTable('eav/attribute')),              'a.attribute_id = ao.attribute_id', array('attribute_code', 'frontend_label'))

				->where('a.attribute_code = ?', $attribute_code)
				->where('ao.option_id = ?', $option_id)
				->where('aov.store_id in (0, ?)', $store_id)
				->order('aov.store_id DESC')
				;

            $data = $read->fetchRow($select);

            if ($data) {
                $object->setData($data);

                //set the default values for the new info page, extracted from the attribute values
                if(!$object->getData('name'))         $object->setData('name', __('Products by %s: %s', $object->getFrontendLabel(), $object->getValue()));
                if(!$object->getData('external_url_label')) $object->setData('external_url_label', __('Visit %s on the web', $object->getValue()));
                if(!$object->getData('identifier'))         $object->setData('identifier', $this->formatUrlKey($object->getValue()));
            }
        }

        $this->_afterLoad($object);

        return $this;
    }

    public function getAllowedAttributes() {
        $allowedAttributes = explode(',', Mage::getStoreConfig('dc_catalog/attributes/selectedattributes'));

    	$select = $this->_getReadAdapter()->select()
        	->from($this->getTable('eav/attribute'), array('attribute_code','frontend_label'))
        	->where('attribute_code IN (?)', $allowedAttributes)
        	;
        return $this->_getReadAdapter()->fetchPairs($select);
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


    /**
     * Check for unique of identifier of page to selected store(s).
     *
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     */
    public function getIsUniqueIdentifier(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getWriteAdapter()->select()
                ->from(array('main_table' => $this->getMainTable()))
                ->where('main_table.identifier = ?', $object->getData('identifier'));
        if ($object->getId()) {
            $select->where('main_table.attribute_page_id <> ?',$object->getId());
        }
        $select->where('main_table.attribute_value_store_id = ?', $object->getData('attribute_value_store_id'));

        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }

        return true;
    }

    /**
     *  Check whether page identifier is numeric
     *
     *  @param    Mage_Core_Model_Abstract $object
     *  @return	  bool
     *  @date	  Wed Mar 26 18:12:28 EET 2008
     */
    protected function isNumericIdentifier (Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
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
        $select = $this->_getReadAdapter()->select()->from(array('main_table'=>$this->getMainTable()), 'attribute_page_id')
            ->where('main_table.attribute_code = ?', $attribute_code)
            ->where('main_table.identifier = ?', $identifier)
            ->where('main_table.attribute_value_store_id IN (0, ?) ', $storeId)
            ->order('attribute_value_store_id DESC');

        return $this->_getReadAdapter()->fetchOne($select);
    }

    /**
     * Try to match an identifier which is not saved
     * return option id if page exists
     *
     * @param   string $identifier
     * @param   int $storeId
     * @return  int
     */
    public function getOptionIdFromIdentifier($attribute_code, $identifier, $storeId)
    {
    	/**
    	 * makes a search in the database for values which are simial to the identifier
    	 * first remove all chars which may be accents in the identifier, and replace them with % for the mysql like comparison
    	 */
        $subst = array(
            '-' => '%', 'a'=>'%', 'c'=>'%', 'd'=>'%', 'e'=>'%', 'i'=>'%', 'n'=>'%', 'o'=>'%', 's'=>'%', 'u'=>'%', 'y'=>'%', 'z'=>'%', 'g'=>'%', 'l'=>'%', 'r'=>'%', 't'=>'%',
        );

        // Replace
        $string = strtr($identifier, $subst);

        while (strpos($string, '%%') !== false) {
        	$string = str_replace('%%', '%', $string);
        }

        $select = $this->_getReadAdapter()->select()
				->from(array('aov' => $this->getTable('eav/attribute_option_value')), array('value'))
				->join(array('ao'  => $this->getTable('eav/attribute_option')), 'ao.option_id = aov.option_id', array('option_id'))
				->join(array('a'   => $this->getTable('eav/attribute')), 'a.attribute_id = ao.attribute_id', array())

				->where('a.attribute_code = ?', $attribute_code)
				->where('aov.value LIKE ?', $string)
				->where('aov.store_id in (0, ?)', $storeId)
				->order('aov.store_id DESC')
				;

        $stmt = $this->_getReadAdapter()->query($select, array());
        //the best stripping function is the provided one in php,
        //so we format all the values that match the identifier,
        //and return the option_id for the one that matches
        while ($result = $stmt->fetch()) {
        	if ($identifier == $this->formatUrlKey($result['value'])) {
        		return $result['option_id'];
        	}
        }

        return false;
    }

}