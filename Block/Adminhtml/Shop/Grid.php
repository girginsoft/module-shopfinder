<?php
namespace Girginsoft\Shopfinder\Block\Adminhtml\Shop;

use Girginsoft\Shopfinder\Model\ResourceModel\Shop\Collection;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Directory\Model\Config\Source\Country;
use Magento\Framework\Module\Manager;
use Magento\Store\Model\WebsiteFactory;

/**
 * Class Grid
 * @package Girginsoft\Shopfinder\Block\Adminhtml\Shop
 */
class Grid extends Extended
{
    /**
     * @var Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory]
     */
    protected $_setsFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Type
     */
    protected $_type;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;

    /**
     * @var Country
     */
    protected $_countryFactory;

    /**
     * @var Collection
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_visibility;

    /**
     * @var WebsiteFactory
     */
    protected $_websiteFactory;

    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param WebsiteFactory $websiteFactory
     * @param Collection $collectionFactory
     * @param Manager $moduleManager
     * @param Country $_countryFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        WebsiteFactory $websiteFactory,
        Collection $collectionFactory,
        Manager $moduleManager,
        Country $_countryFactory,
        array $data = []
    ) {
        $this->_countryFactory = $_countryFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_websiteFactory = $websiteFactory;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('productGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);

    }

    /**
     * @return Store
     */
    protected function _getStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);

        return $this->_storeManager->getStore($storeId);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        try {
            $collection = $this->_collectionFactory->load();
            $this->setCollection($collection);
            parent::_prepareCollection();

            return $this;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;;
        }
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'shop_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'shop_name',
            [
                'header' => __('Shop Name'),
                'index' => 'shop_name',
                'class' => 'shop_name'
            ]
        );

        $this->addColumn(
            'identifier',
            [
                'header' => __('Identifier'),
                'index' => 'identifier',
                'class' => 'identifier'
            ]
        );

        $countries = $this->_countryFactory->toOptionArray();
        $options = [];
        foreach ($countries as $country) {
            if (empty($country["value"])) {
                continue;
            }
            $options[$country["value"]] = $country["label"];
        }

        $this->addColumn(
            'country',
            [
                'header' => __('Country'),
                'index' => 'country',
                'type' => 'select',
                'class' => 'country',
                'options' => $options

            ]
        );

        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'index' => 'image',
                'type' => 'image',
                'class' => 'image'
            ]
        );

        $this->addColumn(
            'creation_time',
            [
                'header' => __('Created At'),
                'type' => 'datetime',
                'index' => 'creation_time',
                'class' => 'creation_time'
            ]
        );

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => __('Delete'),
                'url' => $this->getUrl('shopfinder/*/massDelete'),
                'confirm' => __('Are you sure?')
            )
        );
        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('shopfinder/*/index', ['_current' => true]);
    }

    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            'shopfinder/*/edit',
            ['store' => $this->getRequest()->getParam('store'), 'id' => $row->getId()]
        );
    }
}
