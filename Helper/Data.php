<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    const string CONFIG_MODULE_PATH = 'blog';
    const string CONFIG_GENERAL = 'general';

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @param string $code
     * @param int $storeId
     * @param string $config
     * @return string|int
     */
    private function getConfigGeneral(string $code = '', int $storeId = 0, string $config = self::CONFIG_GENERAL): mixed
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->scopeConfig->getValue(
            static::CONFIG_MODULE_PATH . '/' . $config . $code,
            'default',
            $storeId
        );
    }

    /**
     * Blog module inheritance check
     * @param null $storeId
     * @return int
     */
    public function isEnabled($storeId = null): int
    {
        return (int)$this->getConfigGeneral('status', (int)$storeId);
    }

    /**
     * Show in menu
     * @param null $storeId
     * @return int
     */
    public function toMenu($storeId = null): int
    {
        if (!$this->isEnabled($storeId)) {
            return 0;
        }

        return (int)$this->getConfigGeneral('menu', (int)$storeId);
    }
}

