<?php


namespace core\parser\pages;

class LoginPage
{

    const URL = 'https://freelancehunt.com/profile/login';
    /** @var \phpQueryObject */
    private $pq;


    public function __construct($html)
    {
//        file_put_contents(\Yii::getAlias('@common/data/login.html'), $html);
        $this->pq = \phpQuery::newDocumentHTML($html);
    }


    public function isLogin()
    {
        return !$this->pq->find('#login_form')->count();
    }


}