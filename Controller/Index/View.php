<?php
declare(strict_types=1);

namespace Roweb\Blog\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Roweb\Blog\Api\BlogRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NotFoundException;

class View implements HttpGetActionInterface
{
    private PageFactory $resultPageFactory;
    private BlogRepositoryInterface $postRepository;
    private RequestInterface $request;

    public function __construct(
        PageFactory $resultPageFactory,
        BlogRepositoryInterface $postRepository,
        RequestInterface $request
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postRepository = $postRepository;
        $this->request = $request;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     * @throws NotFoundException
     */
    public function execute(): ResultInterface
    {
        $postId = (int)$this->request->getParam('post_id');
        if (!$postId) {
            throw new NotFoundException(__('Post ID is not specified.'));
        }

        try {
            $post = $this->postRepository->get($postId);
        } catch (NoSuchEntityException $e) {
            throw new NotFoundException(__('The blog post you are looking for does not exist.'));
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($post->getTitle());
        $resultPage->getConfig()->setMetaTitle($post->getMetaTitle() ?: $post->getTitle());
        $resultPage->getConfig()->setDescription($post->getMetaDescription());
        $resultPage->getConfig()->setKeywords($post->getMetaKeywords());

        // Set the post data for the view block
        $block = $resultPage->getLayout()->getBlock('blog_post_view');
        if ($block) {
            $block->setPost($post);
        }

        return $resultPage;
    }
}
