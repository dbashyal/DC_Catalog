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
class DC_Catalog_Block_Admin_Manufacturer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('manufacturer_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('adminhtml')->__('Attribute Info Page'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main_section', array(
            'label'     => Mage::helper('adminhtml')->__('General Information'),
            'title'     => Mage::helper('adminhtml')->__('General Information'),
            'content'   => $this->getLayout()->createBlock('dc_catalog/admin_manufacturer_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $this->addTab('product_section', array(
            'label'     => Mage::helper('adminhtml')->__('Product Page Information'),
            'title'     => Mage::helper('adminhtml')->__('Product Page Information'),
            'content'   => $this->getLayout()->createBlock('dc_catalog/admin_manufacturer_edit_tab_product')->toHtml(),
        ));

        $this->addTab('design_section', array(
            'label'     => Mage::helper('adminhtml')->__('Custom Design'),
            'title'     => Mage::helper('adminhtml')->__('Custom Design'),
            'content'   => $this->getLayout()->createBlock('dc_catalog/admin_manufacturer_edit_tab_design')->toHtml(),
        ));

        $this->addTab('meta_section', array(
            'label'     => Mage::helper('adminhtml')->__('Meta Data'),
            'title'     => Mage::helper('adminhtml')->__('Meta Data'),
            'content'   => $this->getLayout()->createBlock('dc_catalog/admin_manufacturer_edit_tab_meta')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}
