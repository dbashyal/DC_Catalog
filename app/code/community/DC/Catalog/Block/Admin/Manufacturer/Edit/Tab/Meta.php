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
class DC_Catalog_Block_Admin_Manufacturer_Edit_Tab_Meta extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setShowGlobalIcon(true);
    }

    public function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('page_');

        $model = Mage::registry('dc_catalog_manufacturer');

        $fieldset = $form->addFieldset('design_fieldset', array(
            'legend' => Mage::helper('dc_catalog')->__('Meta Data'),
            'class'  => 'fieldset-wide',
        ));

    	$fieldset->addField('page_title', 'text', array(
            'name'      => 'page_title',
            'label'     => Mage::helper('adminhtml')->__('Page Title'),
            'title'     => Mage::helper('adminhtml')->__('Page Title'),
        ));

        $fieldset->addField('meta_keywords', 'editor', array(
            'name' => 'meta_keywords',
            'label' => Mage::helper('dc_catalog')->__('Meta Keywords'),
            'title' => Mage::helper('dc_catalog')->__('Meta Keywords'),
        ));

    	$fieldset->addField('meta_description', 'editor', array(
            'name' => 'meta_description',
            'label' => Mage::helper('dc_catalog')->__('Meta Description'),
            'title' => Mage::helper('dc_catalog')->__('Meta Description'),
        ));

        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
