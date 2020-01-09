<?php

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
