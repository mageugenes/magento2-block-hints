<?php

declare(strict_types=1);

namespace Mageugenes\BlockHints\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\AbstractBlock;
use Mageugenes\BlockHints\Helper\Data as DataHelper;

/**
 *
 * Class Block
 * @package Mageugenes\BlockHints\Observer
 */
class Block implements ObserverInterface
{
    /**
     * @var DataHelper
     */
    protected DataHelper $_dataHelper;

    public function __construct(
        DataHelper $dataHelper
    ) {
        $this->_dataHelper = $dataHelper;
    }

    /**
     * @param Observer $observer
     * @return ObserverInterface
     */
    public function execute(Observer $observer): ObserverInterface
    {
        if ($this->_dataHelper->getConfigValue($this->_dataHelper::CONFIG_PATH_STOREFRONT) ||
            $this->_dataHelper->getConfigValue($this->_dataHelper::CONFIG_PATH_ADMINHTML)) {

            $block = $observer->getData('block');
            $transportObject = $observer->getData('transport');
            $html = $this->getBlockHtml($block, $transportObject->getHtml());
            $transportObject->setHtml($html);
            $observer->setData('transport', $transportObject);
        }

        return $this;
    }

    /**
     * @param AbstractBlock $block
     * @param string $html
     * @return string
     */
    protected function getBlockHtml(AbstractBlock $block, string $html): string
    {
        $nameInLayout = $block->getNameInLayout() ?? 'No name in layout';
        $template = $block->getTemplate() ?? 'No template';
        $blockHash = md5($nameInLayout . $template . rand(0, 1000));

        if ($nameInLayout == 'mageugenes.layoutnames.blocks') {
            return $html;
        }

        $html = <<<HTML
                <div class="debugging-hint-mageugenes-layoutnames" id="me-ln-hint-id-{$blockHash}">
                </div>
                <div class="me-ln-wrapper" id="me-ln-wrapper-me-ln-hint-id-{$blockHash}">
                    <div class="me-ln-name-template">
                         <div>name: {$nameInLayout} </div>
                         <div>template: {$template} </div>
                    </div>
                </div>
                {$html}
                <div class="debugging-hint-mageugenes-layoutnames-end" id="me-ln-hint-id-{$blockHash}-end">
                </div>
        HTML;

        return $html;
    }
}
