<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Roweb\Blog\Controller\Adminhtml\AbstractAction;

class Delete extends AbstractAction
{

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $postId = (int)$this->getRequest()->getParam('post_id');
        if ($postId) {
            try {
                // get model and delete
                $post = $this->getPost();
                $this->blogRepository->delete($post);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Blog Post.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $postId]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Blog Post to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

