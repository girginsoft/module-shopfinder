<?php
/**
 * Created by PhpStorm.
 * User: girginsoft
 * Date: 16.11.2016
 * Time: 02:28
 */

namespace Girginsoft\Shopfinder\Test\Unit\Repository;

use Girginsoft\Shopfinder\Model\ShopRepository;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Class ShopRepositoryTest
 * @package Girginsoft\Shopfinder\Test\Unit\Repository
 */
class ShopRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ShopRepository
     */
    protected $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Girginsoft\Shopfinder\Model\ResourceModel\Shop
     */
    protected $shopResource;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Girginsoft\Shopfinder\Model\Shop
     */
    protected $shop;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Girginsoft\Shopfinder\Api\Data\ShopInterface
     */
    protected $shopData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Girginsoft\Shopfinder\Api\Data\ShopSearchResultInterface
     */
    protected $shopSearchResult;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Api\DataObjectHelper
     */
    protected $dataHelper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Girginsoft\Shopfinder\Model\ResourceModel\Shop\Grid\Collection
     */
    protected $collection;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Initialize repository
     */
    protected function setUp()
    {
        $this->shopResource = $this->getMockBuilder('Girginsoft\Shopfinder\Model\ResourceModel\Shop')
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataObjectProcessor = $this->getMockBuilder('Magento\Framework\Reflection\DataObjectProcessor')
            ->disableOriginalConstructor()
            ->getMock();
        $shopFactory = $this->getMockBuilder('Girginsoft\Shopfinder\Model\ShopFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $shopDataFactory = $this->getMockBuilder('Girginsoft\Shopfinder\Api\Data\ShopInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $storeDataFactory = $this->getMockBuilder('Magento\Store\Api\Data\StoreInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $shopSearchResultFactory = $this->getMockBuilder(
            'Girginsoft\Shopfinder\Api\Data\ShopSearchResultInterfaceFactory'
        )
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $collectionFactory = $this->getMockBuilder(
            'Girginsoft\Shopfinder\Model\ResourceModel\Shop\Grid\CollectionFactory'
        )
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->storeManager = $this->getMockBuilder('Magento\Store\Model\StoreManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $store = $this->getMockBuilder('\Magento\Store\Api\Data\StoreInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $store->expects($this->any())->method('getId')->willReturn(0);
        $this->storeManager->expects($this->any())->method('getStore')->willReturn($store);

        $this->shop = $this->getMockBuilder('Girginsoft\Shopfinder\Model\Shop')
            ->disableOriginalConstructor()
            ->getMock();
        $this->shopData = $this->getMockBuilder('Girginsoft\Shopfinder\Api\Data\ShopInterface')
            ->getMock();
        $this->shopSearchResult = $this->getMockBuilder('Girginsoft\Shopfinder\Api\Data\ShopSearchResultInterface')
            ->getMock();
        $this->collection = $this->getMockBuilder('Magento\Cms\Model\ResourceModel\Page\Collection')
            ->disableOriginalConstructor()
            ->setMethods(['addFieldToFilter', 'getSize', 'setCurPage', 'setPageSize', 'load', 'addOrder'])
            ->getMock();

        $shopFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->shop);
        $shopDataFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->shopData);
        $shopSearchResultFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->shopSearchResult);
        $collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->collection);

        $this->dataHelper = $this->getMockBuilder('Magento\Framework\Api\DataObjectHelper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = new ShopRepository(
            $this->shopResource,
            $shopFactory,
            $shopDataFactory,
            $storeDataFactory,
            $collectionFactory,
            $shopSearchResultFactory,
            $this->dataHelper,
            $this->dataObjectProcessor,
            $this->storeManager
        );

    }

    /**
     * @test
     */
    public function testGetList()
    {
        $field = 'store_id';
        $value = 'magento';
        $condition = 'eq';
        $total = 10;
        $currentPage = 3;
        $pageSize = 2;

        $criteria = $this->getMockBuilder('Magento\Framework\Api\SearchCriteriaInterface')->getMock();
        $filterGroup = $this->getMockBuilder('Magento\Framework\Api\Search\FilterGroup')->getMock();
        $filter = $this->getMockBuilder('Magento\Framework\Api\Filter')->getMock();

        $criteria->expects($this->once())->method('getFilterGroups')->willReturn([$filterGroup]);
        $criteria->expects($this->once())->method('getCurrentPage')->willReturn($currentPage);
        $criteria->expects($this->once())->method('getPageSize')->willReturn($pageSize);
        $filterGroup->expects($this->once())->method('getFilters')->willReturn([$filter]);
        $filter->expects($this->once())->method('getConditionType')->willReturn($condition);
        $filter->expects($this->any())->method('getField')->willReturn($field);
        $filter->expects($this->once())->method('getValue')->willReturn($value);

        $this->collection->addItem($this->shop);
        $this->shopSearchResult->expects($this->once())->method('setSearchCriteria')->with($criteria)->willReturnSelf();
        $this->collection->expects($this->once())
            ->method('addFieldToFilter')
            ->with($field, [$condition => $value])
            ->willReturnSelf();
        $this->shopSearchResult->expects($this->once())->method('setTotalCount')->with($total)->willReturnSelf();
        $this->collection->expects($this->once())->method('getSize')->willReturn($total);
        $this->collection->expects($this->once())->method('setCurPage')->with($currentPage)->willReturnSelf();
        $this->collection->expects($this->once())->method('setPageSize')->with($pageSize)->willReturnSelf();
        $function = function () {
            $args = func_get_args();
            if ($args[0] == "store_id") {
                return null;
            }

            return ["shop_id" => 1, "shop_name" => "foobar"];
        };
        $this->shop->expects($this->any())->method('getData')->will($this->returnCallBack($function));
        $this->shopSearchResult->expects($this->once())->method('setItems')->with(
            [["shop_id" => 1, "shop_name" => "foobar", 'stores' => []]]
        )->willReturn(['someData' => 'abc']);
        $this->dataHelper->expects($this->once())
            ->method('populateWithArray')
            ->with(
                $this->shopData,
                ["shop_id" => 1, "shop_name" => "foobar"],
                'Girginsoft\Shopfinder\Api\Data\ShopInterface'
            );
        $this->dataObjectProcessor->expects($this->once())
            ->method('buildOutputDataArray')
            ->with($this->shopData, 'Girginsoft\Shopfinder\Api\Data\ShopInterface')
            ->willReturn(["shop_id" => 1, "shop_name" => "foobar"]);
        $this->assertEquals($this->shopSearchResult, $this->repository->getList($criteria));
    }

}