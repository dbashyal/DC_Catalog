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
class DC_Catalog_Block_List_All extends Mage_Core_Block_Template
{
	/* @var $_valuesCollection DC_Catalog_Model_Mysql4_Manufacturer_Collection */
	protected $_valuesCollection;

    protected $_attributeCode = null;
/*
    protected function _prepareLayout()
    {
        //$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
        	$attributeCode = Mage::registry('attribute_code');
        	$attributeModel = Mage::getSingleton('catalog/resource_eav_attribute');
            $attributeModel->load($attributeCode, 'attribute_code');
        	var_export($attributeModel);


        // show breadcrumbs
        if (Mage::getStoreConfig('web/default/show_cms_breadcrumbs')
            && ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs'))) {

        	$breadcrumbs->addCrumb(
                'home',
                array(
                	'label'=>Mage::helper('dc_catalog')->__('Home'),
                	'title'=>Mage::helper('dc_catalog')->__('Go to Home Page'),
                	'link'=>Mage::getBaseUrl()
                )
                );
        	$attributeCode = Mage::registry('attribute_code');

        	$breadcrumbs->addCrumb('allvalues', array(
                    'label' => Mage::helper('dc_catalog')->__(ucfirst($attributeCode).'s'),
                ));
        }
    }
*/
    public function getAttributeCode() {
    	if (!$this->_attributeCode) {
        	if (!$this->_attributeCode = $this->getData('attribute_code')) {
	    		if (!$this->_attributeCode = Mage::registry('attribute_code')) {
	        		if (!$this->_attributeCode = $this->getData('default_attribute_code')) {
	        			$this->_attributeCode = 'manufacturer';
	        		}
	        	}
        	}
    	}
    	return $this->_attributeCode;
    }

    /**
     * @return DC_Catalog_Model_Mysql4_Manufacturer_Collection
     */
    public function getValuesCollection()
    {
        if (null === $this->_valuesCollection) {

	        //the attribute value collection
	        $this->_valuesCollection = Mage::getModel('dc_catalog/manufacturer')->getCollection();

	        //set the store id and the main category from the store
	        $this->_valuesCollection
	        	->addStoreFilter(Mage::app()->getStore()->getId(), true)
	        	->addAttributeCodeFilter($this->getAttributeCode())
	        	->addEnabledFilter();
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
