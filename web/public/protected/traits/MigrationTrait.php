<?php

trait MigrationTrait
{
    /*
    *   для класса миграции m260128_002635_insert_new_authors возвратит префикс m260128_002635
    */
    private function getMigrationPrefix(): string
    {
        return join(
            '_',
            array_slice(explode('_', static::class), 0, 2)
        ); // и сюда бы пайпы
    }

    /*
    *   восстановление прежнего автоинкремента после удаления записей из таблицы
    */
    private function restoreAutoincrement(string $tableName, int $deletedRowsCount)
    {
        if (!defined('YII_DEBUG')) return; // на проде автоинкремент не трогаем
        
        $autoIncrement = $this->getDbConnection()->createCommand()->select('AUTO_INCREMENT')
			->from('INFORMATION_SCHEMA.TABLES')
			->where(
				'TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :TABLE_NAME',
				[':TABLE_NAME' => $tableName]
			)
    		->queryScalar();
        $autoIncrement -= $deletedRowsCount;

        $this->execute("ALTER TABLE $tableName AUTO_INCREMENT = $autoIncrement;");
    }
}