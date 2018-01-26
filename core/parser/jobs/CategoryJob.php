<?php


namespace core\parser\jobs;


use core\entities\Category;
use core\helpers\CategoryHelper;
use core\parser\Api;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class CategoryJob extends BaseObject implements JobInterface
{

    public $category_id;

    /** @var Api */
    private $api;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @param \yii\queue\Queue $queue
     * @throws \Exception
     */
    public function execute($queue)
    {
        $this->api = \Yii::$container->get(Api::class);

        $category = Category::find()->where(['id' => $this->category_id])->one();
        if (!$category) {
            return;
        }
        $category->setStatus(CategoryHelper::STATUS_PROGRESS);
        $category->save();

        try {
            $this->api->loadCategory($category);
            $category->setStatus(CategoryHelper::STATUS_COMPLETE);
            $category->save();
        } catch (\Exception $e) {
            $category->setStatus(CategoryHelper::STATUS_ERROR);
            $category->save();
            throw $e;
        }
    }
}