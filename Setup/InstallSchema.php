<?php
/**
 * Ambab CouponList Extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ambab
 *
 * @copyright   Copyright (c) 2019 Ambab (https://www.ambab.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Ambab\CouponList\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Schema Installation Script.
 *
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Add column into salesrule table.
     *
     * {@inheritdoc}
     *
     * MEQP2 Warning: $context necessary for interface
     *
     * @see \Magento\Framework\Setup\InstallSchemaInterface::install()
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength) Over 100 lines due to very verbose table creation
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $slaesruleTable = $setup->getTable('salesrule');

        $columns = [
            'is_visible_in_list' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'LENGTH' => null,
                'nullable' => false,
                'default' => '0',
                'comment' => 'Is Visible in Coupon Listing',
            ],
        ];

        $connection = $setup->getConnection();

        foreach ($columns as $name => $definition) {
            $connection->addColumn($slaesruleTable, $name, $definition);
        }
    }
}
