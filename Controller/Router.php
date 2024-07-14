<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller;

use Roweb\Blog\Helper\Data as HelperData;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Store\Model\StoreManagerInterface;

class Router implements RouterInterface
{

    protected ActionFactory $actionFactory;
    protected HelperData $helperData;
    protected ResponseInterface $_response;
    protected StoreManagerInterface $_storeManager;

    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        HelperData $helperData,
        StoreManagerInterface $storeManager
    )
    {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->helperData = $helperData;
        $this->_storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $identifier = trim($request->getPathInfo(), '/');

        // Verifică dacă URL-ul începe cu 'blog'
        if (strpos($identifier, 'blog') !== 0) {
            return null;
        }

        $pathParts = explode('/', $identifier);

        // Verifică dacă modulul este activat
       /* if (!$this->helperData->isModuleEnabled()) {
            return null;
        }*/

        // Gestionează redirecționarea pentru '/blog/' către '/blog'
        if ($identifier === 'blog' && substr($request->getPathInfo(), -1) === '/') {
            $this->_response->setRedirect($this->_storeManager->getStore()->getBaseUrl() . 'blog', 301);
            $this->_response->sendResponse();
            exit();
        }

        // Rută pentru pagina principală a blogului
        if ($identifier === 'blog') {
            $request->setModuleName('blog')
                ->setControllerName('index')
                ->setActionName('index')
                ->setPathInfo('/blog/index/index');
            return $this->actionFactory->create(Forward::class);
        }

        // Rută pentru vizualizarea unui post specific
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

    private function getPostIdBySlug(string $slug)
    {
        return 4; // @TODO load by slug
    }
}

