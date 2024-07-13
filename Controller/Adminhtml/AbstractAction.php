<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Roweb\Blog\Api\Data\BlogInterface;
use Roweb\Blog\Model\Blog as BlogModel;
use Roweb\Blog\Model\BlogRepository;
use Roweb\Blog\Model\BlogFactory;

abstract class AbstractAction extends Action
{
    const string ADMIN_RESOURCE = 'Roweb_Blog::vendor_menu';

    protected BlogRepository $blogRepository;
    protected BlogFactory $blogFactory;
    protected PageFactory $resultPageFactory;
    protected ForwardFactory $resultForwardFactory;
    protected JsonFactory $jsonFactory;
    protected DataPersistorInterface $dataPersistor;

    /**
     * @param Context $context
     * @param BlogRepository $blogRepository
     * @param BlogFactory $blogFactory
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param JsonFactory $jsonFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        BlogRepository $blogRepository,
        BlogFactory $blogFactory,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        JsonFactory $jsonFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->blogRepository = $blogRepository;
        $this->blogFactory = $blogFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->jsonFactory = $jsonFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage(Page $resultPage): Page
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Roweb'), __('Roweb'))
            ->addBreadcrumb(__('Blog'), __('Blog'));
        return $resultPage;
    }

    /**
     * @return BlogInterface|null
     * @throws LocalizedException|NoSuchEntityException
     */
    public function getPost(): ?BlogInterface
    {
        $postId = (int)$this->getRequest()->getParam('post_id');
        if ($postId) {
            return $this->blogRepository->get($postId);
        }
        return null;
    }

    /**
     * Init the current model.
     *
     * @param int|null $postId
     * @return BlogInterface
     * @throws LocalizedException
     * @throws NotFoundException
     */
    protected function initModel(?int $postId): BlogInterface
    {
        /** @var BlogModel $model */
        $model = $this->blogFactory->create();

        // Initial checking.
        if ($postId) {
            try {
                $model = $this->blogRepository->get($postId);
            } catch (NoSuchEntityException $e) {
                throw new NotFoundException(__('This blog post does not exist.'));
            }
        }

        return $model;
    }
}

