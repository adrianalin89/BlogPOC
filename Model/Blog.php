<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Roweb\Blog\Api\Data\BlogInterface;
use Roweb\Blog\Model\ResourceModel\Blog as ResourceModel;

class Blog extends AbstractModel implements BlogInterface
{

    /**
     * @inheritDoc
     */
    public function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getPostId(): ?int
    {
        return (int)$this->getData(self::POST_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPostId(int $postId): BlogInterface
    {
        return $this->setData(self::POST_ID, $postId);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): BlogInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getSlug(): ?string
    {
        return $this->getData(self::SLUG);
    }

    /**
     * @inheritDoc
     */
    public function setSlug(string $slug): BlogInterface
    {
        return $this->setData(self::SLUG, $slug);
    }

    /**
     * @inheritDoc
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent(string $content): BlogInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedBy(): ?string
    {
        return $this->getData(self::CREATED_BY);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedBy(string $createdBy): BlogInterface
    {
        return $this->setData(self::CREATED_BY, $createdBy);
    }

    /**
     * @inheritDoc
     */
    public function getPublishDate(): ?string
    {
        return $this->getData(self::PUBLISH_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setPublishDate(string $publishDate): BlogInterface
    {
        return $this->setData(self::PUBLISH_DATE, $publishDate);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): ?int
    {
        return (int)$this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(int $status): BlogInterface
    {
        return $this->setData(self::STATUS, $status);
    }
}

