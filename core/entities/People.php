<?php

namespace core\entities;

use Sabirov\AntiCaptcha\NoCaptchaProxyless;
use yii\web\Request;

/**
 * This is the model class for table "people".
 *
 * @property int $id
 * @property string $link
 * @property string $name
 * @property string $email
 * @property string $skype
 * @property string $telegram
 * @property int $status
 * @property int $created_at
 *
 * @property CategoryPeople[] $categoryPeoples
 */
class People extends \yii\db\ActiveRecord
{

    /** @var int */
    public $profile_id;

    /** @var NoCaptchaProxyless */
    public $captcha;

    /** @var Request */
    public $request;


    public static function create($link)
    {
        $model = new self();
        $model->link = $link;
        $model->created_at = time();

        return $model;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function setContacts($contacts)
    {
        foreach ($contacts as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function tableName()
    {
        return 'people';
    }


    public function rules()
    {
        return [
            [['link'], 'required'],
            [['status', 'created_at'], 'integer'],
            [['link', 'name', 'email', 'telegram', 'skype'], 'string', 'max' => 255],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Ссылка',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'name' => 'Имя',
            'email' => 'Email',
            'telegram' => 'Telegram',
            'skype' => 'Skype',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPeoples()
    {
        return $this->hasMany(CategoryPeople::className(), ['people_id' => 'id']);
    }
}
