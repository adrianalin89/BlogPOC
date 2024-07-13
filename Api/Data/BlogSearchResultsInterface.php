<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BlogSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get Blog list.
     * @return BlogInterface[]
     */
    public function getItems(): array;

    /**
     * Set title list.
     * @param BlogInterface[] $items
     * @return $this
     */
    public function setItems(array $items): static;
}

