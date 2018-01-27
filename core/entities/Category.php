<?php

namespace core\entities;

use core\helpers\CategoryHelper;
use core\helpers\PeopleHelper;
use core\parser\elements\Person;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $link
 * @property int $page
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CategoryPeople[] $categoryPeoples
 * @property People[] $peoples
 * @property int $peoplesNew
 * @property int $peoplesWait
 * @property int $peoplesProgress
 * @property int $peoplesError
 * @property int $peoplesComplete
 */
class Category extends \yii\db\ActiveRecord
{

    public static function create($link)
    {
        $category = new self();
        $category->link = $link;
        $category->page = 1;
        $category->status = CategoryHelper::STATUS_NEW;
        $category->created_at = time();
        $category->updated_at = time();

        return $category;
    }

    public function addPerson(Person $person)
    {
        $model = People::find()->where(['link' => $person->link])->one();
        if (!$model) {
            $model = People::create($person->link);
            $model->save();
        }

        $relation = CategoryPeople::find()->where([
            'cat_id' => $this->id,
            'people_id' => $model->id
        ])->one();

        if (!$relation) {
            $relation = new CategoryPeople([
                'cat_id' => $this->id,
                'people_id' => $model->id
            ]);
            $relation->save();
        }
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->updated_at = time();

        return $this;
    }

    public static function tableName()
    {
        return 'category';
    }


    public function rules()
    {
        return [
            [['link'], 'required'],
            [['status', 'created_at', 'updated_at', 'page'], 'integer'],
            [['link'], 'string', 'max' => 255],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Ссылка',
            'page' => 'Текущая страница',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Обновление',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPeoples()
    {
        return $this->hasMany(CategoryPeople::className(), ['cat_id' => 'id']);
    }

    public function getPeoples()
    {
        return $this->hasMany(People::className(), ['id' => 'people_id'])
            ->viaTable(CategoryPeople::tableName(), ['cat_id' => 'id']);
    }

    public function getPeoplesNew()
    {
        $t = People::tableName();
        return $this->hasMany(People::className(), ['id' => 'people_id'])
            ->viaTable(CategoryPeople::tableName(), ['cat_id' => 'id'])
            ->andWhere(["{$t}.status" => PeopleHelper::STATUS_NEW])
            ->count();
    }

    public function getPeoplesWait()
    {
        $t = People::tableName();
        return $this->hasMany(People::className(), ['id' => 'people_id'])
            ->viaTable(CategoryPeople::tableName(), ['cat_id' => 'id'])
            ->andWhere(["{$t}.status" => PeopleHelper::STATUS_WAIT])
            ->count();
    }

    public function getPeoplesProgress()
    {
        $t = People::tableName();
        return $this->hasMany(People::className(), ['id' => 'people_id'])
            ->viaTable(CategoryPeople::tableName(), ['cat_id' => 'id'])
            ->andWhere(["{$t}.status" => PeopleHelper::STATUS_PROGRESS])
            ->count();
    }

    public function getPeoplesError()
    {
        $t = People::tableName();
        return $this->hasMany(People::className(), ['id' => 'people_id'])
            ->viaTable(CategoryPeople::tableName(), ['cat_id' => 'id'])
            ->andWhere(["{$t}.status" => PeopleHelper::STATUS_ERROR])
            ->count();

    }

    public function getPeoplesComplete()
    {
        $t = People::tableName();
        return $this->hasMany(People::className(), ['id' => 'people_id'])
            ->viaTable(CategoryPeople::tableName(), ['cat_id' => 'id'])
            ->andWhere(["{$t}.status" => PeopleHelper::STATUS_COMPLETE])
            ->count();
    }

}
