<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Roweb\Blog\Model\Blog as ModelBlog;
use Roweb\Blog\Model\ResourceModel\Blog as ResourceBlog;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'post_id';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(
            ModelBlog::class,
            ResourceBlog::class
        );
    }
}

