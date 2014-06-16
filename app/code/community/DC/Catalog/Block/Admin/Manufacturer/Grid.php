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
class DC_Catalog_Block_Admin_Manufacturer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('manufacturerGrid');
        $this->setDefaultSort('attribute');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('dc_catalog/manufacturer')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        /*$this->addColumn('attribute_option_id', array(
            'header'    => Mage::helper('dc_catalog')->__('Option ID'),
            'align'     => 'left',
            'index'     => 'attribute_option_id',
        ));*/

        $res = Mage::getResourceModel('dc_catalog/manufacturer');
        $allowedAttributes = $res->getAllowedAttributes();

        $this->addColumn('name', array(
            'header'    => Mage::helper('dc_catalog')->__('Page Name'),
            'align'     => 'left',
            'index'     => 'name',
            'renderer'  => 'dc_catalog/admin_manufacturer_grid_renderer_name',
        ));

        $this->addColumn('attribute_code', array(
            'header'    => Mage::helper('dc_catalog')->__('Attribute'),
            'align'     => 'left',
            'index'     => 'attribute_code',
            'filter_index' => 'a.attribute_code',
            'type'  => 'options',
            'options' => $allowedAttributes,
        ));

        $this->addColumn('value', array(
            'header'    => Mage::helper('dc_catalog')->__('Attribute value'),
            'align'     => 'left',
            'index'     => 'value',
        ));

        /**
         * Check is single store mode
         */
         if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('dc_catalog')->__('Attribute in store'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('identifier', array(
            'header'    => Mage::helper('dc_catalog')->__('Identifier'),
            'align'     => 'left',
            'index'     => 'identifier',
        ));



        $this->addColumn('root_template', array(
            'header'    => Mage::helper('dc_catalog')->__('Layout'),
            'index'     => 'root_template',
            'type'      => 'options',
            'options'   => Mage::getSingleton('page/source_layout')->getOptions(),
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('cms')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('cms')->__('Disabled'),
                1 => Mage::helper('cms')->__('Enabled')
            ),
        ));

        $this->addColumn('creation_time', array(
            'header'    => Mage::helper('dc_catalog')->__('Date Created'),
            'index'     => 'creation_time',
            'type'      => 'datetime',
        ));

        /*$this->addColumn('attr_actions', array(
            'header'    => Mage::helper('dc_catalog')->__('Action'),
            'width'     => 10,
            'sortable'  => false,
            'filter'    => false,
            'renderer'  => 'dc_catalog/admin_manufacturer_grid_renderer_action',
        ));*/

        return parent::_prepareColumns();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        if ($page_id = $row->getData('attribute_page_id')) {
            return $this->getUrl('*/*/edit', array('attribute_page_id' => $page_id));
        }
        return $this->getUrl('*/*/edit', array(
        	'attribute_code' => $row->getData('attribute_code'),
        	'option_id' => $row->getData('option_id'),
        	'store_id' => $row->getData('store_id')
		));

    }
}
