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
class DC_Catalog_Block_Admin_Manufacturer extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'admin_manufacturer';
        $this->_blockGroup = 'dc_catalog';
        $this->_headerText = Mage::helper('dc_catalog')->__('Manage Attribute Info Pages');
        parent::__construct();
        $this->_removeButton('add');
    }

}
