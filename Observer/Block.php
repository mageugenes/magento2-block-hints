<?php

declare(strict_types=1);

namespace Mageugenes\BlockHints\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\AbstractBlock;

/**
 *
 * Class Block
 * @package Mageugenes\BlockHints\Observer
 */
class Block implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return ObserverInterface
     */
    public function execute(Observer $observer): ObserverInterface
    {
        $block = $observer->getData('block');
        $transportObject = $observer->getData('transport');

        $html = $this->getBlockHtml($block, $transportObject->getHtml());

        $transportObject->setHtml($html);

        $observer->setData('transport', $transportObject);

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
