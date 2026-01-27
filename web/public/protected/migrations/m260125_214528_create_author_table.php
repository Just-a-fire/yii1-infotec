<?php

class m260125_214528_create_author_table extends CDbMigration
{
	const TABLE_NAME = 'author';

	public function safeUp()
    {
		// Для очень больших таблиц можно ФИО разнести по отдельным таблицам
		$this->createTable(self::TABLE_NAME, [
			'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY', // pk создает int(11) NOT NULL AUTO_INCREMENT без unsigned
			'first_name' => "VARCHAR(128) NOT NULL COMMENT 'Имя'", //  обязательное поле
			'patronymic' => "VARCHAR(128) COMMENT 'Отчество'",
			'last_name' => "VARCHAR(128) COMMENT 'Фамилия'",
		], 'engine = innodb character set = utf8');

		$nameFields = ['first_name', 'patronymic', 'last_name'];

		$this->createIndex(
			'full_name',
			self::TABLE_NAME,
			$nameFields,
			true
		);

		$fullNames = [
			'Владимир Владимирович Набоков',
			'Фёдор Михайлович Достоевский',
			'Аркадий Натанович Стругацкий',
			'Сергей Александрович Есенин',
			'Михаил Афанасьевич Булгаков',
			'Борис Натанович Стругацкий',
			'Александр Сергеевич Пушкин',
			'Николай Васильевич Гоголь',
			'Александр Иванович Куприн',
			'Михаил Юрьевич Лермонтов',
			'Марина Ивановна Цветаева',
			'Иван Сергеевич Тургенев',
			'Лев Николаевич Толстой',
			'Иван Алексеевич Бунин',
			'Антон Павлович Чехов',
			'Агния Львовна Барто',
		];
		
		$tableRows = array_map(function ($item) use ($nameFields) {
			return array_combine($nameFields, explode(' ', $item));
		}, $fullNames);

		$this->insertMultiple(self::TABLE_NAME, $tableRows);
    }

    public function safeDown()
    {
		$this->delete(self::TABLE_NAME);

		$this->dropIndex('full_name', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}