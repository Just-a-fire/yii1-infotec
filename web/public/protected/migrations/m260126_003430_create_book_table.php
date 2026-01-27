<?php

class m260126_003430_create_book_table extends CDbMigration
{
	const TABLE_NAME = 'book';
	const RELATION_TABLE_NAME = 'author_book';

	public function safeUp()
	{
		/*
			release_year - это год выпуска, а не написания. И если у книг есть ISBN, стандарт которого был разработан в 1966 году, 
			то, вероятно, все книги не раньше XX века, и типа YEAR (1901 - 2155) нам будет достаточно.
			Для тествого задания сделаем допущение, что в нашем каталоге не будет антикварных книг XIX века без ISBN

			isbn - будем хранить в строках для сохранения структуры, может начинаться с 0
			Излишняя оптимизация, скажем, через BIGINT не нужна
		*/
		$this->createTable(self::TABLE_NAME, [
			'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY', // pk создает int(11) NOT NULL AUTO_INCREMENT без unsigned
			'title' => "VARCHAR(256) NOT NULL COMMENT 'Название'",
			'release_year' => "YEAR NOT NULL COMMENT 'Год выпуска'",
			'summary' => "VARCHAR(2024) COMMENT 'Описание'",
			'isbn' => "VARCHAR(17) UNIQUE",
			'photo' => "string COMMENT 'Фото главной страницы'",
			'created_at' => 'timestamp NOT NULL DEFAULT current_timestamp()',
			'updated_at' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		], 'engine = innodb character set = utf8');


		$this->createTable(self::RELATION_TABLE_NAME, [
			'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'author_id' => 'int(11) unsigned NOT NULL',
			'book_id' => 'int(11) unsigned NOT NULL'
		], 'engine = innodb character set = utf8');

		$this->addForeignKey(
			'FK_' . self::RELATION_TABLE_NAME . '_author',
			self::RELATION_TABLE_NAME,
			'author_id',
			'author',
			'id',
			'CASCADE',
			'CASCADE'			
		);
		$this->addForeignKey(
			'FK_' . self::RELATION_TABLE_NAME . '_book',
			self::RELATION_TABLE_NAME,
			'book_id',
			'book',
			'id',
			'CASCADE',
			'CASCADE'
		);


		$books = require_once(Yii::getPathOfAlias('application.migrations.data.books') . '.php');

		foreach ($books as $index => $book) {
			$authorId = array_pop($book);
			$this->insert(self::TABLE_NAME, $book);
			$bookId = $index + 1;
			if (is_array($authorId)) {
				array_walk(
					$authorId,
					fn($id) => $this->insert(
						self::RELATION_TABLE_NAME,
						['author_id' => $id, 'book_id' => $bookId]
					)
				);
			} else {
				$this->insert(
					self::RELATION_TABLE_NAME,
					['author_id' => $authorId, 'book_id' => $bookId]
				);
			}
		}		
	}

	public function safeDown()
	{
		$this->dropForeignKey(
			'FK_' . self::RELATION_TABLE_NAME . '_book',
			self::RELATION_TABLE_NAME
		);
		$this->dropForeignKey(
			'FK_' . self::RELATION_TABLE_NAME . '_author',
			self::RELATION_TABLE_NAME
		);

		$this->dropTable(self::RELATION_TABLE_NAME);

		$this->dropTable(self::TABLE_NAME);
	}
}