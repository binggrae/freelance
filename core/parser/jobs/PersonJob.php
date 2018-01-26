<?php


namespace core\parser\jobs;


use core\entities\People;
use core\exceptions\RequestException;
use core\forms\LoginForm;
use core\helpers\PeopleHelper;
use core\parser\Api;
use core\services\Client;
use Sabirov\AntiCaptcha\NoCaptchaProxyless;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class PersonJob extends BaseObject implements JobInterface
{

    public $ids;

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

        try {
            $people = People::find()->where(['id' => $this->ids])->all();


            foreach ($people as &$person) {
                $form = new LoginForm([
                    'proxy' =>$person->proxy,
                    'login' => \Yii::$app->params['login'],
                    'password' => \Yii::$app->params['password'],
                ]);
                $this->api->login($form);

                $person->setStatus(PeopleHelper::STATUS_PROGRESS);
                $person->save();
            }

            $this->api->loadPeople($people);

        } catch (RequestException $e) {
            $people = People::find()->where(['id' => $this->ids])->all();
            if (!$people) {
                return;
            }
            foreach ($people as $person) {
                $person->setStatus(PeopleHelper::STATUS_ERROR);
                $person->save();
            }
        }
    }
}