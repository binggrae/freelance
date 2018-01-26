<?php


namespace console\controllers;


use core\entities\Category;
use core\helpers\PeopleHelper;
use core\parser\jobs\CategoryJob;
use core\parser\jobs\PersonJob;
use core\parser\pages\ContactPage;
use core\parser\pages\PeoplePage;
use yii\console\Controller;
use yii\web\NotFoundHttpException;

class ParserController extends Controller
{
    public function actionRun($id = 1)
    {
        $category = Category::find()->with('peoples')->where(['id' => $id])->one();
        if (!$category) {
            throw new NotFoundHttpException('Категория не найдена');
        }

        $ids = [];
        foreach ($category->peoples as $person) {
            if(PeopleHelper::isStart($person->status)) {
                $person->setStatus(PeopleHelper::STATUS_WAIT);
//                $person->save();

                $ids[] = $person->id;
            }
        }
        $ids = array_chunk($ids, 10);
        foreach ($ids as $chunk) {
            $job = new PersonJob([
                'ids' => $chunk
            ]);

            $job->execute(null);
            die();
        }
    }


    public function actionTest()
    {
        $html = file_get_contents(\Yii::getAlias('@common/data/contact.html'));

        $page = new ContactPage($html);

        var_dump($page->getContacts());


    }
}