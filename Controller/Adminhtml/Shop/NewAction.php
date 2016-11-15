<?php
namespace Girginsoft\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;

/**
 * Class NewAction
 * @package Girginsoft\Shopfinder\Controller\Adminhtml\Shop
 */
class NewAction extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
