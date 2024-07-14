<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Roweb\Blog\Api\Data\BlogInterface;
use Roweb\Blog\Api\Data\BlogSearchResultsInterface;

interface BlogRepositoryInterface
{

    /**
     * Save Blog
     * @param BlogInterface $post
     * @return BlogInterface
     * @throws LocalizedException
     */
    public function save(BlogInterface $post): BlogInterface;

    /**
     * Retrieve Blog by post ID
     * @param int $postId
     * @return BlogInterface
     * @throws LocalizedException
     */
    public function get(int $postId): BlogInterface;

    /**
     * Retrieve Blog matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): SearchResults;

    /**
     * Delete Blog
     * @param BlogInterface $post
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(BlogInterface $post): bool;

    /**
     * Delete Blog by post ID
     * @param string $postId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(string $postId): bool;
}

