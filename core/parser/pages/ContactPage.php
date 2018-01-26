<?php


namespace core\parser\pages;

use core\exceptions\ContactException;
use yii\web\ForbiddenHttpException;

class ContactPage
{

    const URL = 'https://freelancehunt.com/profile/dogetcontactdetailswithcaptcha';

    /** @var \phpQueryObject */
    private $pq;


    public function __construct($html)
    {
//        file_put_contents(\Yii::getAlias('@common/data/contact. ' . uniqid() . '.html'), $html);
        $this->pq = \phpQuery::newDocumentHTML($html);
    }

    public function getContacts()
    {
        return [
            'telegram' => $this->getTelegram(),
            'email' => $this->getEmail(),
            'skype' => $this->getSkype()
        ];
    }


    private function getTelegram()
    {
        return null;
    }

    private function getEmail()
    {
        return $this->pq->find('a[title="E-mail"]')->text();
    }

    private function getSkype()
    {
        return $this->pq->find('a[title="Skype"]')->text();
    }


}