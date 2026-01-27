<?php

class AuthorBook extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'author_book';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}