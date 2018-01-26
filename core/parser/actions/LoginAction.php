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
     */
    public function run($form)
    {
        $request = $this->client->post(LoginPage::URL, $form->getPostData())->send();
        if ($request->isOk) {
            $home = new LoginPage($request->content);

            return $home->isLogin();
        } else {
            throw new RequestException('Failed auth');
        }
    }

}