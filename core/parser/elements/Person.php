<?php

namespace  core\parser\elements;

class Person
{
    public $link;
    public $name;

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = 'https://freelancehunt.com' . $link;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}