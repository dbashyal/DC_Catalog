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
class DC_Catalog_Block_AttributeInfo extends Mage_Core_Block_Template
{
    public function getAttributeInfo()
    {
        if (!$this->hasData('attributeInfo')) {
            if ($this->getAttributePageId()) {
                $attributeInfo = Mage::getModel('dc_catalog/AttributeInfo')
                    ->load($this->getAttributePageId());
            } else {
                $attributeInfo = Mage::getSingleton('dc_catalog/manufacturer');
            }
            $this->setData('attributeInfo', $attributeInfo);
        }
        return $this->getData('attributeInfo');
    }

    public function getDataOr($data, $default) {
    	if ($res = $this->getData($data))
    		return $res;
    	else
    		return $default;
    }

    protected function _prepareLayout()
    {
        $attributeInfo = $this->getAttributeInfo();

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

	            $breadcrumbs->addCrumb('allvalues', array(
                    'label' => Mage::helper('dc_catalog')->__(ucfirst($attributeInfo->getAttributeCode()).'s'),
                    'link'  => Mage::getUrl(''.$attributeInfo->getAttributeCode().'/'),
                ));


                $breadcrumbs->addCrumb('dc_catalog', array('label'=>$attributeInfo->getValue(), 'title'=>$attributeInfo->getValue()));
        }

        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('attribute-info-'.$attributeInfo->getAttributeCode());
        }

        if ($head = $this->getLayout()->getBlock('head')) {
        	if ($attributeInfo->getPageTitle() > '') {
            	$head->setTitle($attributeInfo->getPageTitle());
        	} else {
            	$head->setTitle($attributeInfo->getName());
        	}
            $head->setKeywords($attributeInfo->getMetaKeywords());
            $head->setDescription($attributeInfo->getMetaDescription());
        }

    }

    public function getDescription() {
        $content = $this->getAttributeInfo()->getDescription();
        $processor = Mage::getModel('core/email_template_filter');
        return $processor->filter($content);
    }

    public function getProductListHtml()
    {
        return $this->getChildHtml('product_list');
    }

    /**
     * return the current page
     * show the logo/description only on the first page
     */
    public function getCurrentPage() {
        $layer = Mage::getSingleton('catalog/layer');
        /* @var $layer Mage_Catalog_Model_Layer */
        if ($layer) {
        	return $layer->getProductCollection()->getCurPage();
        }
        return false;
    }

    /*protected function _toHtml()
    {
        $processor = Mage::getModel('core/email_template_filter');
        $html = $processor->filter($this->getAttributeInfo()->getContent());
        $html = $this->getMessagesBlock()->getGroupedHtml() . $html;
        return $html;
    }*/
}
