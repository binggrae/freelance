<?php


namespace core\parser\actions;


use core\exceptions\RequestException;
use core\forms\LoginForm;
use core\parser\pages\LoginPage;
use core\services\Client;

class LoginAction
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
     * @param LoginForm $form
     * @return bool
     * @throws \yii\httpclient\Exception
     */
    public function run($form)
    {
        $request = $this->client->post(LoginPage::URL, $form->getPostData())->send();
        if ($request->isOk) {
            $home = new LoginPage($request->content);

            return $home->isLogin();
        } else {
            var_dump($request->getStatusCode());
            throw new RequestException('Failed auth');
        }
    }

}