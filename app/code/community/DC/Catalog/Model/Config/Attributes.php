<?php

class DC_Catalog_Model_Config_Attributes extends Mage_Core_Model_Config_Data
{
    const XML_PATH_DC_CATALOG_CONFIG_ATTRIBUTES_VALUES = 'dc_catalog/attributes/selectedattributes';

    protected $_options;

    protected function _construct()
    {
        $this->_init('dc_catalog/config_attributes');
    }

    public function toOptionArray($isMultiselect)
    {
        if ($this->_options) {
            return $this->_options;
        }

        $this->_options[] = array('value' => '', 'label' => 'None');
        $data = $this->_getResource()->getAttributes();
        foreach ($data as $k => $v) {
        	$this->_options[] = array('value' => $k, 'label' => $v);
        }

        return $this->_options;
    }

}
