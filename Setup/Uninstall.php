<?php
/**
 * Created by PhpStorm.
 * User: girginsoft
 * Date: 14.11.2016
 * Time: 14:56
 */

namespace Girginsoft\Shopfinder\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

/**
 * Class Uninstall
 * @package Girginsoft\Shopfinder\Setup
 */
class Uninstall implements UninstallInterface
{
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->dropTable($installer->getTable('shopfinder_shops_store'));
        $installer->getConnection()->dropTable($installer->getTable('shopfinder_shops'));

        $installer->endSetup();
    }
}