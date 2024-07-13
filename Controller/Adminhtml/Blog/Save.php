<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Roweb\Blog\Controller\Adminhtml\AbstractAction;
use Roweb\Blog\Model\Blog as BlogModel;

class Save extends AbstractAction
{
    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            try {
                $postId = (int)$this->getRequest()->getParam('post_id');
                /** @var BlogModel $post */
                $post = $this->initModel($postId);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }

            if (!$post->getPostId() && $postId) {
                $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $post->setData($data);

            try {
                $this->blogRepository->save($post);
                $this->messageManager->addSuccessMessage(__('You saved the post.'));
                $this->dataPersistor->clear('roweb_blog');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $post->getPostId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Blog.'));
            }

            $this->dataPersistor->set('roweb_blog', $data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => (int)$this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

