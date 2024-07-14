<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller;

use Roweb\Blog\Helper\Data as HelperData;
use Roweb\Blog\Model\Blog as BlogModel;
use Roweb\Blog\Model\BlogRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;

class Router implements RouterInterface
{

    protected ActionFactory $actionFactory;
    protected HelperData $helperData;
    protected ResponseInterface $_response;
    protected StoreManagerInterface $_storeManager;
    protected BlogRepository $blogRepository;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        HelperData $helperData,
        StoreManagerInterface $storeManager,
        BlogRepository $blogRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->helperData = $helperData;
        $this->_storeManager = $storeManager;
        $this->blogRepository = $blogRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function match(RequestInterface $request): ?ActionInterface
    {

        // 1. Initial check
        $identifier = trim($request->getPathInfo(), '/');
        if (strpos($identifier, 'blog') !== 0) {
            return null;
        }

        $store = $this->_storeManager->getStore();

        // 2. Check if module is enabled
        if (!$this->helperData->isEnabled($store->getId())) {
            return null;
        }

        // 3. Fallback redirection for tail slashes
        if ($identifier === 'blog' && substr($request->getPathInfo(), -1) === '/') {
            $this->_response->setRedirect($store->getBaseUrl() . 'blog', 301);
            $this->_response->sendResponse();
            exit();
        }

        // 4. Routing for blog main page
        if ($identifier === 'blog') {
            $request->setModuleName('blog')
                ->setControllerName('index')
                ->setActionName('index')
                ->setPathInfo('/blog/index/index');
            return $this->actionFactory->create(Forward::class);
        }

        // 5. Routing for blog post page
        $pathParts = explode('/', $identifier);
        if (count($pathParts) === 2) {
            $slug = $pathParts[1];
            $postId = $this->getPostIdBySlug($slug);

            if ($postId) {
                $request->setModuleName('blog')
                    ->setControllerName('index')
                    ->setActionName('view')
                    ->setParam('post_id', $postId)
                    ->setPathInfo('/blog/index/view');
                return $this->actionFactory->create(Forward::class);
            }
        }

        return null;
    }

    /**
     * Get post id by slug
     * @param string $slug
     * @return int|null
     */
    private function getPostIdBySlug(string $slug): ?int
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('status', BlogModel::STATUS_ACTIVE)
            ->addFilter('slug', $slug, 'eq')
            ->create();
        try {
            $blogPosts = $this->blogRepository->getList($searchCriteria);
            foreach ($blogPosts->getItems() as $post) {
                /** @var BlogModel $post */
                return $post->getPostId();
            }
        } catch (LocalizedException $e) {
        }

        return null;
    }
}

