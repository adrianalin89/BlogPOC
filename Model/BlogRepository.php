<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Roweb\Blog\Api\BlogRepositoryInterface;
use Roweb\Blog\Api\Data\BlogInterface;
use Roweb\Blog\Api\Data\BlogInterfaceFactory;
use Roweb\Blog\Api\Data\BlogSearchResultsInterface;
use Roweb\Blog\Api\Data\BlogSearchResultsInterfaceFactory;
use Roweb\Blog\Model\ResourceModel\Blog as ResourceBlog;
use Roweb\Blog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;

class BlogRepository implements BlogRepositoryInterface
{

    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @var BlogInterfaceFactory
     */
    protected BlogInterfaceFactory $blogFactory;

    /**
     * @var BlogCollectionFactory
     */
    protected BlogCollectionFactory $blogCollectionFactory;

    /**
     * @var ResourceBlog
     */
    protected ResourceBlog $resource;

    /**
     * @var BlogSearchResultsInterfaceFactory
     */
    protected BlogSearchResultsInterfaceFactory $searchResultsFactory;


    /**
     * @param ResourceBlog $resource
     * @param BlogInterfaceFactory $blogFactory
     * @param BlogCollectionFactory $blogCollectionFactory
     * @param BlogSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceBlog $resource,
        BlogInterfaceFactory $blogFactory,
        BlogCollectionFactory $blogCollectionFactory,
        BlogSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->blogFactory = $blogFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(BlogInterface $post): BlogInterface
    {
        try {
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the blog post id: %1',
                $exception->getMessage()
            ));
        }
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function get(int $postId): BlogInterface
    {
        $blog = $this->blogFactory->create();
        $this->resource->load($blog, $postId);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $postId));
        }
        return $blog;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): SearchResults
    {
        $collection = $this->blogCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(BlogInterface $post): bool
    {
        try {
            $blogModel = $this->blogFactory->create();
            $this->resource->load($blogModel, $post->getPostId());
            $this->resource->delete($blogModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Blog: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(string $postId): bool
    {
        return $this->delete($this->get((int)$postId));
    }
}

