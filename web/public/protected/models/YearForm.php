<?php
class YearForm extends CFormModel
{
	public $year;

	public function rules()
	{
		return [
            ['year', 'required'],
			['year', 'numerical', 'min' => 1901, 'max' => date('Y'), 'integerOnly' => true]
        ];
	}

	public function attributeLabels()
	{
		return ['year' => 'Select year'];
	}
}