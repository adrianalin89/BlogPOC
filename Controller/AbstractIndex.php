<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Blog\Controller;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;
use Roweb\Blog\Helper\Data as HelperData;

abstract class AbstractIndex implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;
    /**
     * @var ForwardFactory
     */
    protected ForwardFactory $resultForwardFactory;
    /**
     * @var HelperData
     */
    protected HelperData $helperData;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param HelperData $helperData
     */
    public function __construct(
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        HelperData $helperData
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->helperData = $helperData;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if ($this->helperData->isEnabled()) {
            return $this->resultPageFactory->create();
        }

        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('noroute');

    }
}
