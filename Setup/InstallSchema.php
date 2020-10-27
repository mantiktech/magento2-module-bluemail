<?php
namespace Mantik\Bluemail\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ){
        $setup->startSetup();

        $quote = $setup->getTable('quote');
        $salesOrder = $setup->getTable('sales_order');


        $setup->getConnection()->addColumn(
            $quote,
            'bluemail_notes',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Bluemail Notes'
            ]
        );

        $setup->getConnection()->addColumn(
            $salesOrder,
            'bluemail_notes',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Bluemail Notes'
            ]
        );

        $setup->endSetup();
    }
}
