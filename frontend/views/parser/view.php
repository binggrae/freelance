<?php

use core\entities\Category;
use core\entities\People;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $category Category */

$this->title = 'Категория: ' . str_replace('https://freelancehunt.com/freelancers/', '', $category->link);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= $this->title ?></h1>

    <a href="<?= Url::to(['/parser/download', 'id' => $category->id]); ?>" class="btn btn-success">Скачать</a>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'link',
                'format' => 'raw',
                'value' => function (People $model) {
                    return Html::a(
                        str_replace('https://freelancehunt.com/freelancers/', '', $model->link),
                        $model->link, [
                            'target' => '_blank'
                        ]
                    );
                }
            ],
            'created_at:datetime',
            'name',
            'email',
            'skype'
        ],
    ]); ?>
</div>
