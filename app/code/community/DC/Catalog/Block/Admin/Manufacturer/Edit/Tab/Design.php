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
class DC_Catalog_Block_Admin_Manufacturer_Edit_Tab_Design extends Mage_Adminhtml_Block_Widget_Form
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
            'legend' => Mage::helper('dc_catalog')->__('Design & Meta Data'),
            'class'  => 'fieldset-wide',
        ));

        $fieldset->addField('custom_theme', 'select', array(
            'name'      => 'custom_theme',
            'label'     => Mage::helper('dc_catalog')->__('Custom Theme'),
            'values'    => Mage::getModel('core/design_source_design')->getAllOptions(),
        ));

        $fieldset->addField('custom_theme_from', 'date', array(
            'name'      => 'custom_theme_from',
            'label'     => Mage::helper('dc_catalog')->__('Custom Theme From'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));

        $fieldset->addField('custom_theme_to', 'date', array(
            'name'      => 'custom_theme_to',
            'label'     => Mage::helper('dc_catalog')->__('Custom Theme To'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));


        $fieldset->addField('root_template', 'select', array(
            'name'      => 'root_template',
            'label'     => Mage::helper('dc_catalog')->__('Layout'),
            'required'  => true,
            'values'   => Mage::getSingleton('page/source_layout')->toOptionArray(),
        ));

        $fieldset->addField('layout_update_xml', 'editor', array(
            'name'      => 'layout_update_xml',
            'label'     => Mage::helper('dc_catalog')->__('Layout Update XML'),
            'style'     => 'height:24em;'
        ));

        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
