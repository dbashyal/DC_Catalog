<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     DC_Catalog
 * @copyright   Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('catalog_attribute_page')};

CREATE TABLE IF NOT EXISTS {$this->getTable('catalog_attribute_page')} (
  `attribute_page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attribute_option_id` int(11) NOT NULL,
  `attribute_value_store_id` int(11) NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `root_template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `external_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_url_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `layout_update_xml` text COLLATE utf8_unicode_ci,
  `custom_theme` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_theme_from` date DEFAULT NULL,
  `custom_theme_to` date DEFAULT NULL,
  `creation_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`attribute_page_id`),
  UNIQUE KEY `attribute_unique` (`attribute_code`,`attribute_option_id`,`attribute_value_store_id`,`is_active`),
  KEY `identifier` (`identifier`),
  KEY `attribute_code` (`attribute_code`),
  KEY `attribute_option_id` (`attribute_option_id`,`attribute_value_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attribute Info Pages';

    ");

$installer->endSetup();
