<?php
/**
 * Created by PhpStorm.
 * User: girginsoft
 * Date: 15.11.2016
 * Time: 03:19
 */

namespace Girginsoft\Shopfinder\Api\Data;

/**
 * Interface ShopInterface
 * @package Girginsoft\Shopfinder\Api\Data
 * @api
 */
interface ShopInterface
{
    const ENTITY_ID                = 'shop_id';
    const IDENTIFIER               = 'identifier';
    const SHOP_NAME                = 'shop_name';
    const COUNTRY                  = 'country';
    const IMAGE                    = 'image';

    /**
     * Get ID
     *
     * @return int
     */
    public function getId();
    /**
     * Set ID
     *
     * @param int $id
     * @return \Girginsoft\Shopfinder\Api\Data\ShopInterface
     */
    public function setId($id);

    /**
     * Set Shop Id
     *
     * @param int $id
     * @return \Girginsoft\Shopfinder\Api\Data\ShopInterface
     */
    public function setShopId($id);

    /**
     * Get Store ID
     *
     * @return int[]
     */
    public function getStoreId();

    /**
     * Set Store ID
     *
     * @param int[] $id
     * @return \Girginsoft\Shopfinder\Api\Data\ShopInterface
     */
    public function setStoreId(array $id);

    /**
     * Get Identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Set Identififer
     *
     * @param string $string
     * @return \Girginsoft\Shopfinder\Api\Data\ShopInterface
     */
    public function setIdentifier(string $string);

    /**
     * Get shop name
     *
     * @return string
     */
    public function getShopName();

    /**
     * Set Shop Name
     *
     * @param string $shopName
     * @return \Girginsoft\Shopfinder\Api\Data\ShopInterface
     */
    public function setShopName(string $shopName);

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry();

    /**
     * Set Country
     *
     * @param string $country
     * @return \Girginsoft\Shopfinder\Api\Data\ShopInterface
     */
    public function setCountry(string $country);

    /**
     * Get image
     *
     * @return string
     */
    public function getImage();

    /**
     * Set image
     *
     * @param string $image
     * @return \Girginsoft\Shopfinder\Api\Data\ShopInterface
     */
    public function setImage(string $image);
}