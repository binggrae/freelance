<?php


namespace core\forms;


use yii\base\Model;

class AddForm extends Model
{
    public $link;

    public function rules()
    {
        return [
            [['link'], 'string'],
            [['link'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'link' => 'Ссылка на категорию'
        ];
    }


}