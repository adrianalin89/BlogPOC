<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller\Adminhtml\Blog;

use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultInterface;
use Roweb\Blog\Controller\Adminhtml\AbstractAction;
use Roweb\Blog\Model\Blog;

class InlineEdit extends AbstractAction
{
    /**
     * Inline edit action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $postId) {
                    try {
                        /** @var Blog $post */
                        $post = $this->blogRepository->get($postId);
                        $post->setData(array_merge($post->getData(), $postItems[$postId]));
                        $this->blogRepository->save($post);
                    } catch (\Exception $e) {
                        $messages[] = "[Blog Post ID: {$postId}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}

