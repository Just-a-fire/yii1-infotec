<?php
Yii::import('application.traits.MigrationTrait');

class m260128_051704_insert_new_books extends CDbMigration
{
	use MigrationTrait;

	const TABLE_NAME = 'book';
	const RELATION_TABLE_NAME = 'author_book';

	public function safeUp()
	{
		$newBooks = $this->getNewBooks();

		foreach ($newBooks as $book) {
			$author = array_pop($book); // author в отличии от предыдущей миграции книг только строковый тип

			$chunks = explode(' ', $author);
			if (count($chunks) < 3) continue; // пропускаем Максима Горького и Гюго
			[$firstName, $patronymic, $lastName] = $chunks;

			$authorId = $this->getDbConnection()->createCommand()->select('id')
				->from('author')
				->where(
					'first_name = :first_name AND patronymic = :patronymic AND last_name = :last_name',
					[':first_name' => $firstName, ':patronymic' => $patronymic, ':last_name' => $lastName]
				)
				->queryScalar();

			if (!$authorId) {
				echo "Автор $author не найден в таблице" . PHP_EOL;
				continue;
			}

			try {
				$this->insert(self::TABLE_NAME, $book);
				$bookId = $this->getDbConnection()->getLastInsertID();
				
				$this->insert(
					self::RELATION_TABLE_NAME,
					['author_id' => $authorId, 'book_id' => $bookId]
				);
			} catch (Exception $e) {
				echo $e->getMessage() , PHP_EOL;
			}
		}	
	}

	public function safeDown()
	{
		$newBooks = $this->getNewBooks();

		foreach ($newBooks as $book) {
			$this->delete(
				self::TABLE_NAME,
				'isbn = :isbn',
				[':isbn' => $book['isbn']]
			);
		}

		$this->restoreAutoincrement(self::TABLE_NAME, count($newBooks));
	}

	private function getNewBooks(): array {
		$newBooks = file_get_contents(Yii::getPathOfAlias('application.migrations.data.books') . '_' . $this->getMigrationPrefix() . '.json');
		return json_decode($newBooks, true);
	}
}