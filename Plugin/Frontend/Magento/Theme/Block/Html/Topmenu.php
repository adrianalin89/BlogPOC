<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Plugin\Frontend\Magento\Theme\Block\Html;

use Magento\Store\Model\StoreManagerInterface;
use Roweb\Blog\Helper\Data as HelperData;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\Data\Tree\Node;

class Topmenu
{
    public HelperData $helperData;
    protected TreeFactory $treeFactory;
    private StoreManagerInterface $storeManager;

    public function __construct(
        HelperData $helperData,
        TreeFactory $treeFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->helperData = $helperData;
        $this->treeFactory = $treeFactory;
        $this->storeManager = $storeManager;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ): array
    {
        try {
            $store = $this->storeManager->getStore();
            $storeId = $store->getId();
            $storeUrl = $store->getBaseUrl();
        } catch (\Exception $e) {
            return [$outermostClass, $childrenWrapClass, $limit];
        }

        if ($this->helperData->toMenu($storeId)) {
            $subject->getMenu()->addChild(
                new Node(
                    [
                        'name'       => __(ucfirst('Blog')),
                        'id'         => 'menu-extra-node-blog',
                        'url'        => $storeUrl . 'blog',
                    ],
                    'id',
                    $this->treeFactory->create()
                )
            );
        }

        return [$outermostClass, $childrenWrapClass, $limit];
    }
}

