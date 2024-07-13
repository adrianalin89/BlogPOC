<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Api\Data;

interface BlogInterface
{

    const string PUBLISH_DATE = 'publish_date';
    const string POST_ID = 'post_id';
    const string SLUG = 'slug';
    const string CONTENT = 'content';
    const string CREATED_BY = 'created_by';
    const string TITLE = 'title';
    const string STATUS = 'status';

    /**
     * Get post_id
     * @return int|null
     */
    public function getPostId(): ?int;

    /**
     * Set post_id
     * @param int $postId
     * @return BlogInterface
     */
    public function setPostId(int $postId): BlogInterface;

    /**
     * Get post title
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Set post title
     * @param string $title
     * @return BlogInterface
     */
    public function setTitle(string $title): BlogInterface;

    /**
     * Get post slug
     * @return string|null
     */
    public function getSlug(): ?string;

    /**
     * Set post slug
     * @param string $slug
     * @return BlogInterface
     */
    public function setSlug(string $slug): BlogInterface;

    /**
     * Get post content
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Set post content
     * @param string $content
     * @return BlogInterface
     */
    public function setContent(string $content): BlogInterface;

    /**
     * Get post created by
     * @return string|null
     */
    public function getCreatedBy(): ?string;

    /**
     * Set post created by
     * @param string $createdBy
     * @return BlogInterface
     */
    public function setCreatedBy(string $createdBy): BlogInterface;

    /**
     * Get post publish date
     * @return string|null
     */
    public function getPublishDate(): ?string;

    /**
     * Set post publish date
     * @param string $publishDate
     * @return BlogInterface
     */
    public function setPublishDate(string $publishDate): BlogInterface;

    /**
     * Get post status
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Set status
     * @param int $status
     * @return BlogInterface
     */
    public function setStatus(int $status): BlogInterface;
}

