<?php

use core\entities\Category;
use core\helpers\CategoryHelper;
use core\helpers\PeopleHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <a href="<?=Url::to(['/parser/download']);?>" class="btn btn-success">Скачать</a>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'link',
                'format' => 'raw',
                'value' => function (Category $model) {
                    return Html::a(
                        str_replace('https://freelancehunt.com/freelancers/', '', $model->link),
                        $model->link, [
                            'target' => '_blank'
                        ]
                    );
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function (Category $model) {
                    $html = Html::tag('span', CategoryHelper::getStatusLabel($model->status), [
                        'class' => 'label ' . CategoryHelper::getStatusClass($model->status)
                    ]);
                    if (!CategoryHelper::isDisabled($model->status)) {
                        $html .= ' ';
                        $html .= Html::a('', ['parser/load', 'id' => $model->id], [
                            'class' => 'glyphicon glyphicon-refresh',
                            'style' => 'font-size: 14px',
                            'title' => 'Собрать контакты'
                        ]);
                    }
                    return $html;
                }
            ],
            'updated_at:datetime',
            [
                'header' => '',
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'text-center',
                    'style' => 'font-size: 20px'
                ],
                'value' => function (Category $model) {
                    $html = '';
                    $html .= Html::a('', ['parser/start', 'id' => $model->id], [
                        'class' => 'glyphicon glyphicon-play-circle',
                        'style' => 'font-size: 14px',
                        'title' => 'Запуск парсинга контактов'
                    ]);

                    $html .= ' | ';
                    $html .= Html::a('', ['parser/view', 'id' => $model->id], [
                        'class' => 'glyphicon glyphicon-eye-open',
                        'style' => 'font-size: 14px',
                        'title' => 'Просмотр категории'
                    ]);

                    $html .= ' | ';
                    $html .= Html::a('', ['parser/download', 'id' => $model->id], [
                        'target' => '_blank',
                        'class' => 'glyphicon glyphicon-download-alt',
                        'style' => 'font-size: 14px',
                        'title' => 'Скачать контакты из категории'
                    ]);

                    return $html;
                }
            ],
            [
                'header' => 'Статистика',
                'format' => 'raw',
                'value' => function (Category $model) {
                    $html = '';
                    if ($model->peoplesNew) {
                        $html .= PeopleHelper::getStatusLabel(PeopleHelper::STATUS_NEW) . ': ' .
                            Html::tag('div', $model->peoplesNew, ['class' => 'label label-default']) . '<br>';
                    }
                    if ($model->peoplesWait) {
                        $html .= PeopleHelper::getStatusLabel(PeopleHelper::STATUS_WAIT) . ': ' .
                            Html::tag('div', $model->peoplesWait, ['class' => 'label label-warning']) . '<br>';
                    }
                    if ($model->peoplesProgress) {
                        $html .= PeopleHelper::getStatusLabel(PeopleHelper::STATUS_PROGRESS) . ': ' .
                            Html::tag('div', $model->peoplesProgress, ['class' => 'label label-primary']) . '<br>';
                    }
                    if ($model->peoplesError) {
                        $html .= PeopleHelper::getStatusLabel(PeopleHelper::STATUS_ERROR) . ': ' .
                            Html::tag('div', $model->peoplesError, ['class' => 'label label-danger']) . '<br>';
                    }
                    if ($model->peoplesComplete) {
                        $html .= PeopleHelper::getStatusLabel(PeopleHelper::STATUS_COMPLETE) . ': ' .
                            Html::tag('div', $model->peoplesComplete, ['class' => 'label label-success']) . '<br>';
                    }

                    return $html;
                }
            ]
        ],
    ]); ?>
</div>
