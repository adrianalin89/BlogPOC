<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{

    protected $transportBuilder;
    protected $actionFactory;

    /**
     * Router constructor
     *
     * @param ActionFactory $actionFactory
     */
    public function __construct(
        ActionFactory $actionFactory
    ) {
        $this->actionFactory = $actionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $result = null;

        //@TODO check if module enabled

        /* @TODO create logic for blog
       $identifier = trim($request->getPathInfo(), '/');
        if (strpos($request->getPathInfo(), 'blog')) {
            $requestUri = trim($request->getRequestUri(), '/');
            if ($identifier !== $requestUri && strpos($requestUri, 'blog?') === false) {
                $identifier = $requestUri;
            }
        } else {
            return $result;
        }
         *
         *
        if ($request->getModuleName() != 'blog' && $this->validateRoute($request)) {
            $request->setModuleName('blog')
                ->setControllerName('blog')
                ->setActionName('view') //or listposts
                ->setParam('post_id', $postId);
            $result = $this->actionFactory->create(Forward::class);
        }
         */

        return $result;
    }

    /**
     * @param RequestInterface $request
     * @return bool
     */
    public function validateRoute(RequestInterface $request): bool
    {
        $identifier = trim($request->getPathInfo(), '/');
        return strpos($identifier, 'blog') !== false;
    }
}

