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

class DC_Catalog_Block_Admin_Manufacturer_Edit_Tab_Main
	extends Mage_Adminhtml_Block_Widget_Form
//	implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        $model = Mage::registry('dc_catalog_manufacturer');

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('General Information'),'class'=>'fieldset-wide'));

        if ($model->getAttributePageId()) {
        	$fieldset->addField('attribute_page_id', 'hidden', array(
                'name' => 'attribute_page_id',
            ));
        } else {
        	$fieldset->addField('attribute_code', 'hidden', array('name' => 'attribute_code'));
        	$fieldset->addField('option_id', 'hidden', array('name' => 'option_id'));
        	$fieldset->addField('store_id', 'hidden', array('name' => 'store_id'));
        }

    	$fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('adminhtml')->__('Page Name'),
            'title'     => Mage::helper('adminhtml')->__('Page Name'),
            'required'  => true,
        ));

        $hint = 'domain.com/';
        if($_ac = $model->getAttributeCode()) {
        	$hint .= $_ac.'/';
        }
        $hint .= 'identifier';

    	$fieldset->addField('identifier', 'text', array(
            'name'      => 'identifier',
            'label'     => Mage::helper('adminhtml')->__('SEF URL Identifier'),
            'title'     => Mage::helper('adminhtml')->__('SEF URL Identifier'),
            'required'  => true,
            'class'     => 'validate-identifier',
            'after_element_html' => '<p class="nm"><small>' . Mage::helper('adminhtml')->__('(eg: '.$hint.')') . '</small></p>',
        ));

    	$fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('adminhtml')->__('Status'),
            'title'     => Mage::helper('adminhtml')->__('Status'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('adminhtml')->__('Enabled'),
                '0' => Mage::helper('adminhtml')->__('Disabled'),
            ),
            'after_element_html' => '<p class="nm"><small>' . Mage::helper('adminhtml')->__('Disabled values will not appear in the list, and will not have a link on them in the product pages') . '</small></p>',
        ));

    	$fieldset->addField('favorite', 'text', array(
            'name'      => 'favorite',
            'label'     => Mage::helper('adminhtml')->__('Favorite'),
            'title'     => Mage::helper('adminhtml')->__('Favorite'),
            'required'  => false,
            'after_element_html' => '<p class="nm"><small>' . Mage::helper('adminhtml')->__('You can order favorites by this number: the lowest will display first') . '</small></p>',
        ));

        $fieldset->addField('image', 'image', array(
            'name'      => 'image',
            'label'     => Mage::helper('adminhtml')->__('Logo/Picture'),
            'title'     => Mage::helper('adminhtml')->__('Logo/Picture'),
            'required'  => false,
        	'value' => null,
            'after_element_html' => '<p class="nm"><small>' . Mage::helper('adminhtml')->__('The logo will display in the list and product pages') . '</small></p>',
        ));
    	$fieldset->addField('external_url', 'text', array(
            'name'      => 'external_url',
            'label'     => Mage::helper('adminhtml')->__('External URL'),
            'title'     => Mage::helper('adminhtml')->__('External URL'),
            'required'  => false,
        ));
    	$fieldset->addField('external_url_label', 'text', array(
            'name'      => 'external_url_label',
            'label'     => Mage::helper('adminhtml')->__('Label for external URL'),
            'title'     => Mage::helper('adminhtml')->__('Label for external URL'),
            'required'  => false,
        ));

    	$fieldset->addField('description', 'editor', array(
            'name'      => 'description',
            'label'     => Mage::helper('adminhtml')->__('Content'),
            'title'     => Mage::helper('adminhtml')->__('Content'),
            'style'     => 'height:36em;',
            'wysiwyg'   => true,
            'config'    => Mage::getVersion() > '1.4' ? @Mage::getSingleton('cms/wysiwyg_config')->getConfig() : false,
            'required'  => false,
        ));


        //fix the image upload nag
        $values = $model->getData();
        if (is_array($values) && isset($values['image'])) {
	        if (is_array($values['image']) && isset($values['image']['value'])) {
				$values['image'] = 'catalog/attribute/'.$values['image']['value'];
			} elseif (is_string($values['image']) && ($values['image'] > '')) {
				$values['image'] = 'catalog/attribute/'.$values['image'];
			}
        }
        $form->addValues($values);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
