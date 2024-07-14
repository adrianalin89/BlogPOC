<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Block\Index;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Roweb\Blog\Helper\Data as HelperData;
use Roweb\Blog\Model\BlogRepository;
use Roweb\Blog\Model\Blog as BlogModel;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Index extends Template
{

    protected HelperData $helperData;
    protected BlogRepository $blogRepository;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * Constructor
     *
     * @param Context $context
     * @param HelperData $helperData
     * @param BlogRepository $blogRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        HelperData $helperData,
        BlogRepository $blogRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->helperData = $helperData;
        $this->blogRepository = $blogRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    public function getPosts(): array
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('status', BlogModel::STATUS_ACTIVE)
            ->create();
        try {
            $blogPosts = $this->blogRepository->getList($searchCriteria);
            return $blogPosts->getItems();
        } catch (LocalizedException $e) {
            return [];
        }
    }
}

