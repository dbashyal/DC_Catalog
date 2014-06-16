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
class DC_Catalog_Block_Admin_Manufacturer_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	* Load Wysiwyg on demand and Prepare layout
	* credits to Craig Thompson and Alex-s
	*/
	protected function _prepareLayout() {
		parent::_prepareLayout();
		if (Mage::getVersion() > '1.4') {
			if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
				$block->setCanLoadTinyMce(true);
			}
		}
	}

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
        				'id' => 'edit_form',
        				'action' => $this->getData('action'),
        				'method' => 'post',
        				'enctype' => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
