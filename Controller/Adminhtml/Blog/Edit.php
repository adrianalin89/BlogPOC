<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Roweb\Blog\Controller\Adminhtml\AbstractAction;
use Roweb\Blog\Model\Blog as BlogModel;

class Edit extends AbstractAction
{

    /**
     * Edit action
     *
     * @return ResultInterface|Page
     */
    public function execute(): ResultInterface|Page
    {
        // 1. Get ID and create model
        $postId = (int)$this->getRequest()->getParam('post_id');
        try {
            /** @var BlogModel $post */
            $post = $this->initModel($postId);
        } catch (NotFoundException|LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        // 2. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $postId ? __('Edit Post') : __('New Post'),
            $postId ? __('Edit Post') : __('New Post')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Blog'));
        $resultPage->getConfig()->getTitle()->prepend($post->getId() ?
            __('Edit %1', $post->getTitle()) : __('New Post'));
        return $resultPage;
    }
}

