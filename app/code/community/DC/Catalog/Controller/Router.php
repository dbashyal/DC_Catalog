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

class DC_Catalog_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{
	/**
	 * Adds extra router to check for identifiers from the attribute_page table
	 * The request must be of the form /[attribute_code]/[attribute_identifier]/
	 * For example /manufacturer/sony/
	 *
	 * @param $observer
	 */
    public function initControllerRouters($observer)
    {
        $front = $observer->getEvent()->getFront();

        $dcCatalog = new DC_Catalog_Controller_Router();
        $front->addRouter('info', $dcCatalog);
    }

    /**
     * Checks
     *
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        $params = trim($request->getPathInfo(), '/');
        $params = explode('/', $params);

        $attribute_code = $params[0];
        $identifier = null;
        if(isset($params[1])) {
        	$identifier = $params[1];
        }
        $allowedAttributes = explode(',', Mage::getStoreConfig('dc_catalog/attributes/selectedattributes'));


        $attributes = Mage::getModel('dc_catalog/manufacturer');
	    /* @var $attributes DC_Catalog_Model_Manufacturer */
        if (in_array($attribute_code, $allowedAttributes)) {

        	//we have something here... try to match to one of the existing attributes
        	//first, search in attribute_pages for an existing match
	        if ($attributePageId = $attributes->checkIdentifierInPages($attribute_code, $identifier, Mage::app()->getStore()->getId())) {
	        	//we have a winnnner!!!
		        $request->setModuleName('attributeinfo')
		            ->setControllerName('AttributeInfo')
		            ->setActionName('view')
		            ->setParam('attribute_page_id', $attributePageId);

				$request->setAlias(
					Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
					$attribute_code.'/'.$identifier
				);
				return true;
	        }

        	//second, search in attributes for a possible match
	        if (($option_id = $attributes->getOptionIdFromIdentifier($attribute_code, $identifier, Mage::app()->getStore()->getId())) > 0) {
	        	//if ($attributes->getData('attribute_code') > '') {
	        	    //we have another winnnner!!!
	        		$request->setModuleName('attributeinfo')
			            ->setControllerName('AttributeInfo')
			            ->setActionName('view')
			            ->setParam('attribute_code', $attribute_code)
			            ->setParam('option_id', $option_id);

					$request->setAlias(
						Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
						$attribute_code.'/'.$identifier
					);
					return true;
	        	//}
	        }


	        //well.. just display all the values
        	$request->setModuleName('attributeinfo')
	            ->setControllerName('AttributeInfo')
	            ->setActionName('viewAll')
	            ->setParam('attribute_code', $attribute_code);

			$request->setAlias(
				Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
				$attribute_code.'/'.$identifier
			);
			return true;


        }

        //we didn't find anything acceptable in this router, resume search in others
        return false;
    }
}