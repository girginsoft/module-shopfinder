<?php
namespace Girginsoft\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;

/**
 * Class MassDelete
 * @package Girginsoft\Shopfinder\Controller\Adminhtml\Shop
 */
class MassDelete extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $ids = $this->getRequest()->getParam('id');
        if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addError(__('Please select shops'));
        } else {
            try {
                foreach ($ids as $id) {
                    $row = $this->_objectManager->get('Girginsoft\Shopfinder\Model\Shop')->load($id);
                    $row->delete();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been deleted.', count($ids))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }
}
