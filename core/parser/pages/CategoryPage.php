<?php


namespace core\parser\pages;


use core\parser\elements\Person;

class CategoryPage
{

    /** @var \phpQueryObject */
    private $pq;


    public function __construct($html)
    {
//        file_put_contents(\Yii::getAlias('@common/data/cat.html'), $html);
        $this->pq = \phpQuery::newDocumentHTML($html);
    }

    public function getPeople()
    {
        $links = $this->pq->find('.url.biggest');

        foreach ($links as $link) {
            $person = new Person();
            $person->setLink(pq($link)->attr('href'));
            $person->setName(pq($link)->find('.fn')->text());

            yield $person;
        }

        return null;
    }

    public function hasNext()
    {
        return (boolean)$this->pq->find('.next-page-marker')->attr('href');
    }


}