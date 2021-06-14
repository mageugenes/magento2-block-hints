<?php

namespace Mageugenes\BlockHints\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**#@+
     * Config paths
     */
    const CONFIG_PATH_STOREFRONT = 'mageugenes_dev/block_hints/enable_block_hints_for_storefront';
    const CONFIG_PATH_ADMINHTML = 'mageugenes_dev/block_hints/enable_block_hints_for_adminhtml';
    /**#@-*/

    /**
     * @param $field
     * @return mixed
     */
    public function getConfigValue($field)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE
        );
    }
}
