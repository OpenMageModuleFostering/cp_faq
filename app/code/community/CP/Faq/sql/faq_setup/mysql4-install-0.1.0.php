<?php
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('faq'))
    ->addColumn('faq_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Increment ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 125, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'title')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 500, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'description')    
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'status')
    ->addColumn('faq_category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'default'   => '0',
        ), 'faq_category_id')
      ->addColumn('is_faq', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'is_faq')  
        ->addColumn('username', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'username') 
        ->addColumn('useremail', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'useremail')   
    ->setComment('Faq Main Table');
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
    ->newTable($installer->getTable('faq_category'))
    ->addColumn('faq_cat_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Increment ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 125, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'name')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'status')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, array(
        'unsigned'  => true,
        'default'   => '0',
        ), 'identifier')
    ->setComment('Faq Category Main Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
     
