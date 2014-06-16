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
class DC_Catalog_AttributeInfoController extends Mage_Core_Controller_Front_Action
{

    public function indexAction() {
		echo '123';
    }

    /**
     * View attribute info page action
     *
     */
    public function viewAction()
    {
    	$attributePageId = $this->getRequest()
            ->getParam('attribute_page_id', $this->getRequest()->getParam('id', false));
    	$attributeCode = $this->getRequest()->getParam('attribute_code', false);
    	$option_id = $this->getRequest()->getParam('option_id', false);


        $helper = Mage::helper('dc_catalog/AttributeInfo');
        /* @var $helper DC_Catalog_Helper_AttributeInfo */
        if ($helper->loadAttributePage($this, $attributePageId, $attributeCode, $option_id)) {

        	$helper->renderAttributePage($this);

        } else {
        	//no page found, neither generic attribute info found, so display the noroute way
        	$this->_forward('noRoute');
        }

    }

    /**
     * View all attribute values
     *
     */
    public function viewAllAction()
    {
    	$attributeCode = $this->getRequest()->getParam('attribute_code', false);
        Mage::register('attribute_code', $attributeCode);

        $helper = Mage::helper('dc_catalog/AttributeInfo');
        /* @var $helper DC_Catalog_Helper_AttributeInfo */

       	$helper->renderAllAttributesPage($this);

    }
}
