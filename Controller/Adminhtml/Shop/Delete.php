<?php
namespace Girginsoft\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;

/**
 * Class Delete
 * @package Girginsoft\Shopfinder\Controller\Adminhtml\Shop
 */
class Delete extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
		$id = $this->getRequest()->getParam('id');
		try {
				$banner = $this->_objectManager->get('Girginsoft\Shopfinder\Model\Shop')->load($id);
				$banner->delete();
                $this->messageManager->addSuccess(
                    __('Delete successfully !')
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
	    $this->_redirect('*/*/');
    }
}
