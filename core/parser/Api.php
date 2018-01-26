<?php


namespace core\parser;


use core\entities\Category;
use core\entities\People;
use core\parser\actions\CategoryAction;
use core\parser\actions\LoginAction;
use core\parser\actions\PeopleAction;

class Api
{
    /** @var CategoryAction */
    private $category;
    /**
     * @var PeopleAction
     */
    private $people;
    /**
     * @var LoginAction
     */
    private $login;


    public function __construct(
        CategoryAction $categoryAction,
        PeopleAction $peopleAction,
        LoginAction $loginAction
    )
    {
        $this->category = $categoryAction;
        $this->people = $peopleAction;
        $this->login = $loginAction;
    }

    public function login($form)
    {
        return $this->login->run($form);
    }

    /**
     * @param Category $category
     */
    public function loadCategory(Category $category)
    {
        $this->category->run($category);
    }

    /**
     * @param People[] $people
     */
    public function loadPeople($people)
    {
        $this->people->run($people);
    }


}