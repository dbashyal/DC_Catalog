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
class DC_Catalog_Block_Admin_Manufacturer_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Form
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

        $fieldset = $form->addFieldset('product_fieldset', array(
        	'legend'=>Mage::helper('adminhtml')->__('Information to be displayed in the product pages'),
        	'class'=>'fieldset-wide'
        ));

        $fieldset->addField('banner', 'image', array(
            'name'      => 'banner',
            'label'     => Mage::helper('adminhtml')->__('Banner'),
            'title'     => Mage::helper('adminhtml')->__('Banner'),
            'required'  => false,
            'after_element_html' => '<p class="nm"><small>' . Mage::helper('adminhtml')->__('Banner to be displayed in the product page') . '</small></p>',
        ));

    	$fieldset->addField('description_in_page', 'textarea', array(
            'name'      => 'description_in_page',
            'label'     => Mage::helper('adminhtml')->__('Description in product page'),
            'title'     => Mage::helper('adminhtml')->__('Description in product page'),
    		'rows' 		=> 3,
    		'cols' 		=> 30,
            'style'     => 'height:5em;',
            'required'  => false,
            'after_element_html' => '<p class="nm"><small>' . Mage::helper('adminhtml')->__('Add this text next to the value in the product page') . '</small></p>',
    	));


        //fix the image upload nag
        $values = $model->getData();
        if (is_array($values['banner']) && isset($values['banner']['value'])) {
			$values['banner'] = 'catalog/attribute/'.$values['banner']['value'];
		} elseif (is_string($values['banner']) && ($values['banner'] > '')) {
			$values['banner'] = 'catalog/attribute/'.$values['banner'];
        }
        $form->setValues($values);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
