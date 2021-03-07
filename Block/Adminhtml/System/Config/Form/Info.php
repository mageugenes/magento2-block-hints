<?php

namespace Mageugenes\BlockHints\Block\Adminhtml\System\Config\Form;

use Magento\Store\Model\ScopeInterface;
use Magento\Config\Block\System\Config\Form\Field;

/**
 * Information block
 */
class Info extends Field
{
    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $moduleList;

    /**
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
    }

    /**
     * Return info block html
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $module = $this->moduleList->getOne($this->getModuleName());
        $html = '<div style="padding:10px;background-color:#f8f8f8;border:1px solid #e3e3e3;">
            Mageugenes_BlockHints v' . $module['setup_version'] . ' was developed by <a href="//mageugenes.com" target="_blank">Mageugenes.com</a>
        </div>';

        return $html;
    }
}
