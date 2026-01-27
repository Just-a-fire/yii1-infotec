<?php

class SubscriptionForm extends CFormModel
{
    public $name;
    public $phone;


    public function rules()
	{
		return [
            ['name',  'length', 'max' => 40],
            ['phone', 'required'],
            ['phone', 'unique', 'message' => 'This phone is already in use'],
            [
                'phone',
                'match',
                'pattern' => '/^(8)[(](\d{3})[)](\d{3})[-](\d{2})[-](\d{2})/',
                'message' => 'Телефона, должно быть в формате 8(XXX)XXX-XX-XX'
            ],
        ];
	}

	public function attributeLabels()
	{
		return ['phone' => 'phone', 'name' => 'name'];
	}
}