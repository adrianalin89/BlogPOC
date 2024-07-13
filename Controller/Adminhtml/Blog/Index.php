<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller\Adminhtml\Blog;

use Magento\Framework\Controller\ResultInterface;
use Roweb\Blog\Controller\Adminhtml\AbstractAction;

class Index extends AbstractAction
{
    /**
     * Index action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__("Blog"));
            return $resultPage;
    }
}

