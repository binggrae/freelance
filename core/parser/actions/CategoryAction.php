<?php


namespace core\parser\actions;


use core\entities\Category;
use core\exceptions\RequestException;
use core\parser\pages\CategoryPage;
use core\services\Client;

class CategoryAction
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
     * @param Category $category
     */
    public function run(Category $category)
    {
        do {
            $proxy = Client::getProxy();
            $request = $this->client->get($category->link . '?page=' . $category->page, [
                'proxy' => $proxy,
            ])->send();
            if ($request->isOk) {
                $page = new CategoryPage($request->content);
                foreach ($page->getPeople() as $person) {
                    $category->addPerson($person);
                }
            } else {
                throw new RequestException('Ошибка загрузки категории');
            }
            var_dump($category->page);
            $category->page++;
            $category->save();
        } while ($page->hasNext());

    }

}