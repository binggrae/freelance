<?php


namespace core\parser\pages;


class PeoplePage
{

    /** @var \phpQueryObject */
    private $pq;


    public function __construct($html)
    {
//        file_put_contents(\Yii::getAlias('@common/data/people.html'), $html);
        $this->pq = \phpQuery::newDocumentHTML($html);
    }

    public function getId()
    {
        return $this->pq->find('.g-recaptcha')->attr('data-profile-id');
    }

    public function getName()
    {
        return $this->pq->find('h1 span')->text();
    }
}