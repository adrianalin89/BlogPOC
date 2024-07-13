<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blog extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('roweb_blog', 'post_id');
    }
}

