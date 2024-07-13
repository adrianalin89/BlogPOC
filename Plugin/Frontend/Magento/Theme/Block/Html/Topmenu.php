<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Plugin\Frontend\Magento\Theme\Block\Html;

class Topmenu
{

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ): array
    {
        //@TODO add to menu
        return [$outermostClass, $childrenWrapClass, $limit];
    }
}

