<?php
namespace Girginsoft\Shopfinder\Block\Adminhtml\Shop;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

/**
 * CMS block edit form container
 * @package Girginsoft\Shopfinder\Block\Adminhtml\Shop
 */
class Edit extends Container
{
    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @param Context|Context $context
     * @param Registry $coreRegistry
     * @param array $data
     */
    public function __construct(Context $context, Registry $coreRegistry, array  $data = [])
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set($this->getHeaderText());

        return parent::_prepareLayout();
    }

    /**
     * _Construct
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Girginsoft_Shopfinder';
        $this->_controller = 'adminhtml_shop';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Shop'));
        $this->buttonList->update('delete', 'label', __('Delete Shop'));

        $this->buttonList->add(
            'saveandcontinue',
            array(
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => array(
                    'mage-init' => array('button' => array('event' => 'saveAndContinueEdit', 'target' => '#edit_form'))
                )
            ),
            -100
        );
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('shopfinder_shop')->getId()) {
            return __(
                "Edit Shop '%1 (%2)'",
                $this->escapeHtml($this->_coreRegistry->registry('shopfinder_shop')->getShopName()),
                $this->escapeHtml($this->_coreRegistry->registry('shopfinder_shop')->getId())
            );
        } else {
            return __('New Shop');
        }
    }
}
