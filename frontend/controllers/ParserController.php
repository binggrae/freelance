<?php


namespace frontend\controllers;


use core\entities\Category;
use core\entities\People;
use core\forms\AddForm;
use core\helpers\CategoryHelper;
use core\helpers\PeopleHelper;
use core\parser\jobs\CategoryJob;
use core\parser\jobs\PersonJob;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ParserController extends Controller
{


    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
            'sort' => array(
                'defaultOrder' => ['id' => SORT_DESC],
            ),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }


    public function actionAdd()
    {
        $form = new AddForm();

        if ($form->load(\Yii::$app->request->post())) {
            $category = Category::create($form->link);
            if ($category->save()) {
                return $this->redirect('index');
            } else {
                $form->errors = $category->errors;
            }
        }

        return $this->render('add', [
            'model' => $form
        ]);

    }


    public function actionView($id)
    {
        $category = Category::find()->where(['id' => $id])->one();
        if (!$category) {
            throw new NotFoundHttpException('Категория не найдена');
        }

        $query = People::find()
            ->leftJoin('category_people', 'people.id = category_people.people_id')
            ->andWhere(['category_people.cat_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'category' => $category
        ]);

    }

    public function actionDownload($id = null)
    {
        $query = People::find()->where(['status' => PeopleHelper::STATUS_COMPLETE]);
        if($id) {
            $query->leftJoin('category_people', 'people.id = category_people.people_id')
                ->andWhere(['category_people.cat_id' => $id]);
        }

        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [
                'Person' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => $query,
                    'attributes' => ['link', 'name', 'email', 'skype'],
                ]
            ]
        ]);
        $file->send();

    }

    public function actionLoad($id)
    {
        $category = Category::find()->where(['id' => $id])->one();
        if (!$category) {
            throw new NotFoundHttpException('Категория не найдена');
        }

        $category->setStatus(CategoryHelper::STATUS_WAIT);
        $category->save();

        \Yii::$app->queue->push(new CategoryJob([
            'category_id' => $category->id
        ]));

        return $this->redirect(['/parser/index']);
    }

    public function actionStart($id)
    {
        $category = Category::find()->with('peoples')->where(['id' => $id])->one();
        if (!$category) {
            throw new NotFoundHttpException('Категория не найдена');
        }

        $ids = [];
        foreach ($category->peoples as $person) {
            if (PeopleHelper::isStart($person->status)) {
                $person->setStatus(PeopleHelper::STATUS_WAIT);
                $person->save();

                $ids[] = $person->id;
            }
			
        }
        $ids = array_chunk($ids, 5);
        foreach ($ids as $chunk) {
            \Yii::$app->queue->push(new PersonJob([
                'ids' => $chunk
            ]));
        }

        return $this->redirect(['/parser/index']);
    }
}