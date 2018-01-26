<?php


namespace core\parser\actions;


use core\entities\People;
use core\helpers\PeopleHelper;
use core\parser\pages\ContactPage;
use core\parser\pages\PeoplePage;
use core\services\Client;
use Sabirov\AntiCaptcha\NoCaptchaProxyless;

class PeopleAction
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param People[] $people
     */
    public function run($people)
    {
        $this->createCaptcha($people);
        $this->createRequest($people);

        $this->getProfile($people);

        foreach ($people as &$person) {
            $person->setStatus(PeopleHelper::STATUS_ERROR);
            if ($person->captcha->waitForResult()) {
                $response = $this->client->post(ContactPage::URL, [
                    'profile_id' => $person->profile_id,
                    'g_recaptcha_response' => $person->captcha->getTaskSolution(),
                    'proxy' => $person->proxy,
                ])->send();

                if ($response->isOk) {
                    if (isset($response->data['success'])) {
                        $page = new ContactPage($response->data['message']);
                        $person->setContacts($page->getContacts());
                        $person->setStatus(PeopleHelper::STATUS_COMPLETE);
                    } else {
                        file_put_contents(\Yii::getAlias('@common/data/contact. ' . uniqid() . '.html'), $response->content);
                        var_dump(1);
                    }
                } else {
                    var_dump(2);
                }
            } else {
                var_dump(3);
            }

            $person->save();
        }
    }

    /**
     * @param People[] $people
     */
    private function createCaptcha(&$people)
    {
        foreach ($people as &$person) {
            $antiCaptcha = new NoCaptchaProxyless();
            $antiCaptcha->setKey(\Yii::$app->params['token']);
            $antiCaptcha->setWebsiteURL('https://freelancehunt.com');
            $antiCaptcha->setWebsiteKey(\Yii::$app->params['siteKey']);
            $antiCaptcha->createTask();

            $person->captcha = $antiCaptcha;
        }
    }

    /**
     * @param People[] $people
     */
    private function createRequest(&$people)
    {
        foreach ($people as &$person) {
            $person->request = $this->client->get($person->link, [
                'proxy' => $person->proxy,
            ]);
        }
    }


    /**
     * @param People[] $people
     */
    private function getProfile(&$people)
    {
        $requests = [];
        foreach ($people as $person) {
            $requests[$person->id] = $person->request;
        }
        $responses = $this->client->batch($requests);

        foreach ($people as &$person) {
            if ($responses[$person->id]->isOk) {
                $page = new PeoplePage($responses[$person->id]->content);
                $person->profile_id = $page->getId();
                $person->name = $page->getName();
            } else {
                $person->setStatus(PeopleHelper::STATUS_ERROR);
            }
        }
    }

}